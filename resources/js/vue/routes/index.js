import ProductsComponent from '../pages/products';
import ProductComponent from '../pages/product';
import CategoriesComponent from '../pages/categories';
import TasksComponent from '../pages/tasks';


const routes = [
    { path: '/products',            component: ProductsComponent },    
    { path: '/products/:id',        component: ProductComponent,    name:  'products' },    
    { path: '/categories',          component: CategoriesComponent},    
    { path: '/tasks',               component: TasksComponent},    
    { path: '/',                    redirect: '/products' },
    { path: '*',                    component: ProductsComponent }
]

export default routes;
