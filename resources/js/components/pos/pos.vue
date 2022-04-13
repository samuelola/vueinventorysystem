<template>
  <div>
    
    
     <div class="container-fluid" id="container-wrapper">
          
          <div class="row mb-3">
            

            <!-- Area Chart -->
            <div class="col-xl-5 col-lg-5">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                  <a style="color:#fff" class="btn btn-sm btn-info" href="#">Add Customer</a>
                </div>
                  <div class="table-responsive" style="font-size:12px;">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit($)</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="allcartitem in allcartitems" :key="allcartitem.id">
                        <td>{{allcartitem.pro_name}}</td>
                        
                        <td><input type="text" readonly="" :value="allcartitem.pro_quantity" style="width:30px;text-align: center;">

                            <button  @click.prevent="increment(allcartitem.id)" class="btn btn-sm btn-success">+</button>


                            <button @click.prevent="decrement(allcartitem.id)" class="btn btn-sm btn-info"  v-if="allcartitem.pro_quantity >=2 ">-</button>

                            <button  class="btn btn-sm btn-info"  v-else="" disabled="">-</button>
                        </td>
                        <td>{{allcartitem.product_price}}</td>
                        <td>{{allcartitem.sub_total}}</td>
                        <td><a @click="removeCartItems(allcartitem.id)" class="btn btn-sm btn-danger"><font color="#ffffff">X</font></a></td>
                      </tr>
                     
                    </tbody>
                  </table>
                </div>

                 <div class="card-footer">
                      <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Quantity:
                            <strong>{{qty}}</strong>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            SubTotal :
                            <strong>${{formatPrice(subtotal)}}</strong>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Vat:
                            <strong>{{vats.vat}}%</strong>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total :
                            <strong>${{formatPrice(subtotal * vats.vat/100 + subtotal)}}</strong>
                          </li>
                      </ul>

                        <br>

                        <form @submit.prevent="orderdone">
                          <label for="">Customer Name</label>
                          <select name="" id="" v-model="customer_id" class="form-control">

                               <option v-for="customer in customers" :value="customer.id">
                                   {{customer.name}}
                               </option>
                          </select>
                          <label for="">Pay</label>
                          <input type="text" class="form-control" required="" v-model="pay">
                          <label for="">Due</label>
                          <input type="text" class="form-control" required="" v-model="due">
                          <label for="">Pay By</label>
                          <select name="" id="" v-model="payby" class="form-control">
                               <option value="Hand cash">Hand cash</option>
                               <option value="Gift Card">Gift Card</option>
                               <option value="Cheque">Cheque</option>
                          </select>
                          <button style="margin-top: 12px;" type="submit" class="btn btn-success">Submit</button>
                        </form>
                 </div>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-7 col-lg-7">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                 
                </div>



                <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Products</a>
  </li>
  <li class="nav-item" v-for="category in categories" :key="category.id" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="subproduct(category.id)">{{category.category_name}}</a>
  </li>
  <!-- <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
  </li> -->
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    
    <div class="card-body">
                  <input type="text" v-model="searchTerm" class="form-control" style="width:560px" placeholder="Search Product">
                  <br>
                    <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id">
                         <button v-if="product.product_quantity >= 1" class="btn btn-sm" @click.prevent="addToCart(product.id)">
                          <div class="card" style="width: 8.5rem;">
                            <img :src="product.image" id="em_photo" class="card-img-top" >
                            <div class="card-body">
                              <h6 class="card-title">{{product.product_name}}</h6>
                              <span class="badge badge-success" v-if="product.product_quantity >= 1">
                                
                                  Available {{product.product_quantity}}
                              </span>

                              <span class="badge badge-danger" v-else=" ">Stock out 0</span>
                              
                            </div>
                          </div>

                          </button>

                          <button v-else=" " disabled class="btn btn-sm" @click.prevent="addToCart(product.id)">
                          <div class="card" style="width: 8.5rem;">
                            <img :src="product.image" id="em_photo" class="card-img-top" >
                            <div class="card-body">
                              <h6 class="card-title">{{product.product_name}}</h6>
                              <span class="badge badge-success" v-if="product.product_quantity >= 1">
                                
                                  Available {{product.product_quantity}}
                              </span>

                              <span class="badge badge-danger" v-else=" ">Stock out 0</span>
                              
                            </div>
                          </div>

                          </button>
                      </div>
                  </div>
                </div>

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    
      <div class="card-body">
                  <input type="text" v-model="getsearchTerm" class="form-control" style="width:560px" placeholder="Search Product">
                  <br>
                    <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getfilterSearch" :key="getproduct.id">
                         <button class="btn btn-sm" @click.prevent="addToCart(getproduct.id)">
                          <div class="card" style="width: 8.5rem;">
                            <img :src="getproduct.image" id="em_photo" class="card-img-top" >
                            <div class="card-body">
                              <h6 class="card-title">{{getproduct.product_name}}</h6>
                              <span class="badge badge-success" v-if="getproduct.product_quantity >= 1">
                                
                                  Available {{getproduct.product_quantity}}
                              </span>

                              <span class="badge badge-danger" v-else=" ">Stock out 0</span>
                              
                            </div>
                          </div>

                          </button>
                      </div>
                  </div>
                </div>


  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
</div>

 
                
                
              </div>
            </div>
           
           
          </div>
          

         

        </div>
    
          

  </div>
</template>

<script>

 export default{


  //this makes vue load this method first

  created(){
     
      if(!User.loggedIn()){
          
          this.$router.push({name: '/'})
      }
  },

  created(){
        this.vat();
        this.allProduct();
        this.allCategory();
        this.allCustomer();
        this.allCartItems();
        Reload.$on('Aftercart',()=>{

            this.allCartItems();
        })
      },



  data(){


    return {
        customer_id:'',
        payby:'',
        due:'',
        pay:'',
        products:[],
        categories:'',
        getproducts:[],
        searchTerm:'',
        getsearchTerm:'',
        customers:'',
        errors:'',
        allcartitems:[],
        vats:[],
        pro_id:''
    }

  },

  computed:{

    filterSearch(){

      return this.products.filter(theproduct => {

          return theproduct.product_name.match(this.searchTerm)
      })
    }
    ,

    getfilterSearch(){

      return this.getproducts.filter(gettheproduct => {

          return gettheproduct.product_name.match(this.getsearchTerm)
      })
    },

    qty(){

      let sum = 0;

      for(let i = 0; i < this.allcartitems.length; i++){
             
             sum += (parseFloat(this.allcartitems[i].pro_quantity));
      }

        return sum;
    },


    subtotal(){

      let sum = 0;

      for(let i = 0; i < this.allcartitems.length; i++){
             
             sum += (parseFloat(this.allcartitems[i].pro_quantity) * parseFloat(this.allcartitems[i].product_price));
      }

        return sum;
    }

    

    
  },




   methods:{

       formatPrice(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

       orderdone(){

          let total = this.subtotal * this.vats.vat/100 + this.subtotal;
          var data = {qty:this.qty, subtotal:this.subtotal, customer_id:this.customer_id,pay:this.pay,due:this.due,payby:this.payby,vats:this.vats.vat,total:total}

          axios.post('/api/orderdone',data)
           .then( () => {

               Notification.success()
               this.$router.push({name:'order'})
           })
           
       },

       vat(){
            
             axios.get('/api/vats/')
             .then(({data}) => (this.vats = data))
             .catch()
       },

       increment(id){
          
          axios.get('/api/increment/' + id)
          .then(() => {

             Reload.$emit('Aftercart')

             Notification.success()

          })
          .catch()
       },

       decrement(id){
            
            axios.get('/api/decrement/' + id)
          .then(() => {

             Reload.$emit('Aftercart')

             Notification.success()

          })
          .catch()
       },


       // delete item

       removeCartItems(id){
          
           axios.get('/api/removecartitem/' + id)
         .then(() => {

            Reload.$emit('Aftercart')

            Notification.cart_delete()

         })
         .catch()
       },

      //get all cart items

      allCartItems(){

          axios.get('/api/allcartitems/')
         .then(({data}) => (this.allcartitems = data))
         .catch()
      },


      //add to cart 
      addToCart(id){

        axios.get('/api/addToCart/' + id)
         .then(() => {

            Reload.$emit('Aftercart')

            Notification.cart_success()

         })
         .catch()
       
       },


      allProduct(){

         axios.get('/api/product/')
         .then(({data}) => (this.products = data))
         .catch()
       
       },


       allCategory(){

         axios.get('/api/category/')
         .then(({data}) => (this.categories = data))
         .catch()
       
       },


       allCustomer(){

         axios.get('/api/customer/')
         .then(({data}) => (this.customers = data))
         .catch(console.log('error'))
       
       },


       subproduct(id){

         axios.get('/api/getting/product/' + id)
         .then(({data}) => (this.getproducts = data))
         .catch()
       
       }

      
      
      }

      
  

 }

   

</script>

<style scoped>
  #em_photo{

    width:auto;
    height:130px;
  }
</style>