
const Comment = ({commemt}) => {
    return <>
        <div className="d-flex align-items-start">
            <img style={{width:"35px"}} className="me-2 avatar-sm rounded-circle"
                 src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Luigi"
                 alt="Luigi Avatar"/>
            <div className="w-100">
                <div className="d-flex justify-content-between">
                    <h6 className="">{commemt?.user?.name}
                    </h6>
                    <small className="fs-6 fw-light text-muted"> {commemt?.display_created_at}</small>
                </div>
                <p className="fs-6 mt-3 fw-light">
                    {commemt?.content_comment}
                </p>
            </div>
        </div>
    </>
}

export default Comment;