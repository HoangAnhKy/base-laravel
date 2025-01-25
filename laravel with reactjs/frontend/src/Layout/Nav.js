import {NavLink} from "react-router-dom";
import {useConfigGlobal} from "../Config/Config";

const Nav = () => {

    const CONFIG = useConfigGlobal();

    return <>
        <nav className="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark ticky-top bg-body-tertiary"
             data-bs-theme="dark">
            <div className="container">
                <NavLink to="/" className={`navbar-brand fw-light`}> <span className="fas fa-brain me-1"> </span>Ideas</NavLink>

                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul className="navbar-nav">'
                        {
                            !CONFIG.userLogin ? <>
                                <li className="nav-item">
                                    <NavLink to="/login"
                                             className={({isActive}) => `nav-link ${isActive ? "active" : ""}`}>Login</NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink to="/register"
                                             className={({isActive}) => `nav-link ${isActive ? "active" : ""}`}>Register</NavLink>
                                </li>
                            </> : <>
                                <li className="nav-item">
                                    <button type="button" className="nav-link" onClick={CONFIG.handleLogout}>Logout</button>
                                </li>

                                <li className="nav-item">
                                    <NavLink to="/profile"
                                             className={({isActive}) => `nav-link ${isActive ? "active" : ""}`}>{CONFIG?.userLogin?.name}</NavLink>
                                </li>
                            </>
                        }
                    </ul>
                </div>
            </div>
        </nav>
    </>
}

export default Nav;