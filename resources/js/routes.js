import Home from './views/Home';
import About from './views/About';
import Notes from './views/Notes';
import SubjectNote from './views/SubjectNote';
import PDFView from './views/PDFView';
import Assignments from './views/Assignments'; 
import AandQ from './views/AandQ';
import Assessments from './views/Assessments'; 
import Verify from './views/Verify'; 
import PasswordReset from './views/PasswordReset'; 

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
            path: '/note/:id',
            component: SubjectNote,
            name: 'SubjectNote',
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
            path: '/pdfview/:type/:id',
            component: PDFView,
            name: 'PDFView',
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
            path: '/assignments',
            component: Assignments,
            name: 'Assignments',
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
            path: '/announcements-queries',
            component: AandQ,
            name: 'AandQ',
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
            path: '/assessments',
            component: Assessments,
            name: 'Assessments',
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
            path: '/verify-email-or-reset',
            component: Verify,
            name: 'Verify',     
        },
        {
            path: '/password-reset',
            component: PasswordReset,
            name: 'PasswordReset',     
        },
    ]
}