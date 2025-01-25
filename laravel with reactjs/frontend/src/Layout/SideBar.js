import {NavLink} from "react-router-dom";

const SideBar = () => {
    return <>
        <div className="card overflow-hidden">
            <div className="card-body pt-3">
                <ul className="nav nav-link-secondary flex-column fw-bold gap-2">
                    <li className="nav-item">
                        <NavLink to="/" className={({isActive}) => `nav-link ${isActive ? "bg-info-subtle" : "text-dark"}`}> <span>Home</span></NavLink>
                    </li>
                </ul>
            </div>
            <div className="card-footer text-center py-2">
                <NavLink to="/profile" className="btn btn-link btn-sm text-decoration-none"> View Profile </NavLink>
            </div>
        </div>
    </>
}

export default SideBar;