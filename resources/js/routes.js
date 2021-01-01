import Home from './views/Home';
import About from './views/About';
import Notes from './views/Notes';
import SubjectNote from './views/SubjectNote';
import PDFView from './views/PDFView';
import Assignments from './views/Assignments'; 
import AandQ from './views/AandQ';
import Assessments from './views/Assessments'; 

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
            path: '/note/:id',
            component: SubjectNote,
            name: 'SubjectNote',
            
        },
        {
            path: '/pdfview/:type/:id',
            component: PDFView,
            name: 'PDFView',
            
        },  
        {
            path: '/assignments',
            component: Assignments,
            name: 'Assignments',
            
        },  
        {
            path: '/announcements-queries',
            component: AandQ,
            name: 'AandQ',
            
        }, 
        {
            path: '/assessments',
            component: Assessments,
            name: 'Assessments',
            
        },
    ]
}