const Profile = () => {
    return <>
        <div className="card">
            <div className="px-3 pt-4 pb-2">
                <div className="d-flex align-items-center justify-content-between">
                    <div className="d-flex align-items-center">
                        <img style={{width: "150px"}} className="me-3 avatar-sm rounded-circle"
                             src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt="Mario Avatar"/>
                        <div>
                            <h3 className="card-title mb-0"><a href="#"> Mario
                            </a></h3>
                            <span className="fs-6 text-muted">@mario</span>
                        </div>
                    </div>
                </div>
                <div className="px-2 mt-4">
                    <h5 className="fs-5"> About : </h5>
                    <p className="fs-6 fw-light">
                        This book is a treatise on the theory of ethics, very popular during the
                        Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes
                        from a line in section 1.10.32.
                    </p>
                    <div className="d-flex justify-content-start">
                        <a href="#" className="fw-light nav-link fs-6 me-3"> <span className="fas fa-user me-1">
                                    </span> 120 Followers </a>
                        <a href="#" className="fw-light nav-link fs-6 me-3"> <span className="fas fa-brain me-1">
                                    </span> 2 </a>
                        <a href="#" className="fw-light nav-link fs-6"> <span className="fas fa-comment me-1">
                                    </span> 2 </a>
                    </div>
                    <div className="mt-3">
                        <button className="btn btn-primary btn-sm"> Follow</button>
                    </div>
                </div>
            </div>
        </div>
    </>
}

export default Profile;