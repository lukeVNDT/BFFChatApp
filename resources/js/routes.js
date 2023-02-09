import Profile from './components/ProfileComponent';
import SideMessage from './components/SideMessage';
import OtherProfile from './components/OtherProfile';

const routes = [
    {
        path: '/profile',
        component: Profile,
        name: 'profile',
    },
    {
        path: '/',
        component: SideMessage,
        name: 'chat'
    },
    {
        path: '/otherprofile/:id',
        component: OtherProfile,
        name: 'otherprofile'
    }
];

export default routes;