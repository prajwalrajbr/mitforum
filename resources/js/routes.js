import Home from './views/Home';
import About from './views/About';
import Notes from './views/Notes';
import SubjectNote from './views/SubjectNote';

import PageNotFound from './views/PageNotFound';

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
            path: '/notes',
            component: Notes,
            name: 'Notes',
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
            path: '/note/:subject',
            component: SubjectNote,
            name: 'SubjectNote',
            
        }
    ]
}