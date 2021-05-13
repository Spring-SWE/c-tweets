import Home from './pages/Home'
import Latest from './pages/Latest'
import ShowTweet from './pages/ShowTweet'
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


