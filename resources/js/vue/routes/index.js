import ProductsComponent from '../pages/products';
import ProductComponent from '../pages/product';
import CategoriesComponent from '../pages/categories';


const routes = [
    { path: '/products',            component: ProductsComponent },    
    { path: '/products/:id',        component: ProductComponent,    name:  'products' },    
    { path: '/categories',          component: CategoriesComponent},    
    { path: '/',                    redirect: '/products' },
    { path: '*',                    component: ProductsComponent }
]

export default routes;
