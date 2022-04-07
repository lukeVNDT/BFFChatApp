import Profile from './components/ProfileComponent';
import SideChat from './components/SideChat';
import OtherProfile from './components/OtherProfile';

const routes = [
    {
        path: '/profile',
        component: Profile,
        name: 'profile',
    },
    {
        path: '/',
        component: SideChat,
        name: 'chat'
    },
    {
        path: '/otherprofile/:id',
        component: OtherProfile,
        name: 'otherprofile'
    }
];

export default routes;