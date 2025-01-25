const Follow = () => {
    return <>
        <div className="card mt-3">
            <div className="card-header pb-0 border-0">
                <h5 className="">Who to follow</h5>
            </div>
            <div className="card-body">
                <div className="hstack gap-2 mb-3">
                    <div className="avatar">
                        <a href="#!"><img className="avatar-img rounded-circle"
                                          src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt=""/></a>
                    </div>
                    <div className="overflow-hidden">
                        <a className="h6 mb-0" href="#!">Mario Brother</a>
                        <p className="mb-0 small text-truncate">@Mario</p>
                    </div>
                    <a className="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i
                        className="fa-solid fa-plus"> </i></a>
                </div>
                <div className="hstack gap-2 mb-3">
                    <div className="avatar">
                        <a href="#!"><img className="avatar-img rounded-circle"
                                          src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt=""/></a>
                    </div>
                    <div className="overflow-hidden">
                        <a className="h6 mb-0" href="#!">Mario Brother</a>
                        <p className="mb-0 small text-truncate">@Mario</p>
                    </div>
                    <a className="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i
                        className="fa-solid fa-plus"> </i></a>
                </div>
                <div className="d-grid mt-3">
                    <a className="btn btn-sm btn-primary-soft" href="#!">Show More</a>
                </div>
            </div>
        </div>
    </>
}
export default Follow;