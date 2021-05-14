import Home from './pages/Home'
import Latest from './pages/Latest'
import ShowTweet from './pages/ShowTweet'
import Change from './pages/Change'
import About from './pages/About'
import Support from './pages/Support'
import NotFound from './pages/NotFound'

export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },

    {
        path: '/latest',
        name: 'latest',
        component: Latest,
    },
    {
        path: '/show/:id',
        name: 'show',
        component: ShowTweet
    },

    {
        path: '/change',
        name: 'change',
        component: Change
    },

    {
        path: '/about',
        name: 'about',
        component: About,
    },
    {
        path: '/support',
        name: 'support',
        component: Support,
    },
    {
        path: '*',
        name: 'notFound',
        component: NotFound
    },

];


