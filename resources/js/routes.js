
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;

// end authentication
let home = require('./components/home.vue').default;

// employee
let storeemployee = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let editemployee = require('./components/employee/edit.vue').default;

//supplier
let storesupplier = require('./components/supplier/create.vue').default;
let supplier = require('./components/supplier/index.vue').default;
let editsupplier = require('./components/supplier/edit.vue').default;


//category
let storecategory = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let editcategory = require('./components/category/edit.vue').default;


//product
let storeproduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editproduct = require('./components/product/edit.vue').default;


//customer
let storecustomer = require('./components/customer/create.vue').default;
let customer = require('./components/customer/index.vue').default;
let editcustomer = require('./components/customer/edit.vue').default;


//pos

let pos = require('./components/pos/pos.vue').default;


//order

let order = require('./components/order/order.vue').default;

let searchorder = require('./components/order/search.vue').default;



export const routes = [
  { path: '/', component: login, name:'/' },
  { path: '/register', component:register, name:'register' },
  { path: '/home', component:home, name:'home' },
  { path: '/forget', component:forget, name:'forget' },
  { path: '/logout', component:logout, name:'logout' },

  //employee route
  { path: '/store-employee', component:storeemployee, name:'storeemployee' },
  { path: '/employee', component:employee, name:'employee' },
  { path: '/edit-employee/:id', component:editemployee, name:'edit-employee' },

  //supplier route
  { path: '/store-supplier', component:storesupplier, name:'storesupplier' },
  { path: '/supplier', component:supplier, name:'supplier' },
  { path: '/edit-supplier/:id', component:editsupplier, name:'edit-supplier' },

  //category route
  { path: '/store-category', component:storecategory, name:'storecategory' },
  { path: '/category', component:category, name:'category' },
  { path: '/edit-category/:id', component:editcategory, name:'edit-category' },


  //product route
  { path: '/store-product', component:storeproduct, name:'storeproduct' },
  { path: '/product', component:product, name:'product' },
  { path: '/edit-product/:id', component:editproduct, name:'edit-product' },


  //customer route
  { path: '/store-customer', component:storecustomer, name:'storecustomer' },
  { path: '/customer', component:customer, name:'customer' },
  { path: '/edit-customer/:id', component:editcustomer, name:'edit-customer' },


  //pos route

  { path: '/pos', component:pos, name:'pos' },

   //order route

  { path: '/order', component:order, name:'order' },

  { path: '/searchorder', component:searchorder, name:'searchorder' },


]