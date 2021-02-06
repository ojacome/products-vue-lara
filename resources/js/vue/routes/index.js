import ProductsComponent from '../pages/products';
import ProductComponent from '../pages/product';


const routes = [
    { path: '/products',            component: ProductsComponent },    
    { path: '/products/:id',        component: ProductComponent },    
    { path: '/', redirect: '/products' },
    { path: '*', component: ProductsComponent }
]

export default routes;
