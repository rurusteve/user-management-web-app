import Dashboard from "views/Dashboard.js";
import UserList from "components/Users/List.js";
import AddUser from "components/Users/Add.js";
import Readme from "components/Documentation/Readme"

var routes = [
  {
    path: "/dashboard",
    name: "Dashboard",
    icon: "tim-icons icon-chart-pie-36",
    component: Dashboard,
    layout: "/admin",
  },
  {
    path: "/add/user",
    name: "Add User",
    icon: "tim-icons icon-single-02",
    component: AddUser,
    layout: "/admin",
  },
  {
    path: "/users",
    name: "User List",
    icon: "tim-icons icon-puzzle-10",
    component: UserList,
    layout: "/admin",
  },
  {
    path: "/documentation",
    name: "Documentation",
    icon: "tim-icons icon-book-bookmark",
    component: Readme,
    layout: "/admin",
  },
];
export default routes;
