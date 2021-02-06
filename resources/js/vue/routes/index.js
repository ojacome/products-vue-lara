import ProductsComponent from '../pages/products';


const routes = [
    { path: '/products', component: ProductsComponent },    
    { path: '/', redirect: '/products' },
    { path: '*', component: ProductsComponent }
]

export default routes;
