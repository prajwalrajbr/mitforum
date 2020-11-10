import Home from './views/Home';
import About from './views/About';

export default{
    mode: 'history',

    routes: [
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