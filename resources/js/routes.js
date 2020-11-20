import Home from './views/Home';
import About from './views/About';
import PageNotFound from './views/PageNotFound';
import Login from './views/Login';
import { before } from 'lodash';
import user from './apis/user';

export default{
    mode: 'history',

    routes: [
        {
            path: '*',
            component: PageNotFound,
            name: 'PageNotFound'
        },
        {
            path: '/',
            component: Home,
            name: 'Home'
        },
        {
            path: '/about',
            component: About,
            name: 'About',
            beforeEnter:(to, from, next) => {
                user.authenticated()
                .then(() => {
                    next();
                })
                .catch(()=>{
                    return next({ name: 'Home'});
                })
            }
        },
        {
            path: '/login',
            component: Login,
            name: 'Login'
        }
    ]
}