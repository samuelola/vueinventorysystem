<template>
	<div class="">
		  <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Sale Amount</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">${{formatPrice(todaysale)}}</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Income</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">${{formatPrice(todayincome)}}</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Due</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">${{formatPrice(todaydue)}}</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Since last month</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Stock</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{productcount}}</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          
           
          </div>
          <!--Row-->

          <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Out of Stock Products</h6>
                 
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Buying Price</th>
                        <th>Status</th>
                        <th>Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="stockproduct in stockproducts" :key="stockproduct.id">
                        <td>{{stockproduct.product_name}}</td>
                        <td>{{stockproduct.product_code}}</td>
                        <td><img :src="stockproduct.image" id="em_photo" alt=""></td>
                        <td>{{stockproduct.category_name}}</td>
                        <td>{{stockproduct.buying_price}}</td>
                        <td v-if="stockproduct.product_quantity >= 1">
                          
                          <span class="badge badge-success">
                                
                                  Available 
                          </span>
                        </td>
                        <td v-else="">
                          
                          <span class="badge badge-danger">
                                
                                  Stock Out
                          </span>
                        </td>
                        <td>{{stockproduct.product_quantity}}</td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
	</div>
</template>

<script>

 export default{

  created(){
     
      if(!User.loggedIn()){
          
          this.$router.push({name: '/'})
      }

     
  },


  data(){

    return {

        todaysale:'',
        due:'',
        todayincome:'',
        todaydue:'',
        productcount:'',
        stockproducts:[]
    }

  },

  mounted(){

     this.todaySale();
     this.todayIncome();
     this.todayDue();
     this.todayProduct();
     this.stockProduct();
  },

  methods:{

    formatPrice(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

     todaySale(){

        axios.get('/api/today/sale')
           .then(({data}) => (this.todaysale = data))
           .catch(error =>this.errors = error.response.data.errors)
     },

     todayIncome(){

        axios.get('/api/today/income')
           .then(({data}) => (this.todayincome = data))
           .catch(error =>this.errors = error.response.data.errors)
     },

     todayDue(){

        axios.get('/api/today/due')
           .then(({data}) => (this.todaydue = data))
           .catch(error =>this.errors = error.response.data.errors)
     },

      todayProduct(){

        axios.get('/api/today/product')
           .then(({data}) => (this.productcount = data))
           .catch(error =>this.errors = error.response.data.errors)
     }
       ,

     stockProduct(){

        axios.get('/api/today/stockproduct')
           .then(({data}) => (this.stockproducts = data))
           .catch(error =>this.errors = error.response.data.errors)
     }
  }

   
 }

   

</script>

<style scope>
  #em_photo{

    width:40px;
    height:40px;
  }
</style>