import Home from './views/Home';
import About from './views/About';
import PageNotFound from './views/PageNotFound';

export default{
    mode: 'history',

    routes: [
        {
            path: '*',
            component: PageNotFound
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/about',
            component: About
        }
    ]
}