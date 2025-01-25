import Comment from "../Comments/Comment.jsx";
import PostComment from "../Comments/PostComment.jsx";

const Idea = ({idea, setReload}) => {
    return <>
        <div key={idea.id} className="mt-3">
            <div className="card">
                <div className="px-3 pt-4 pb-2">
                    <div className="d-flex align-items-center justify-content-between">
                        <div className="d-flex align-items-center">
                            <img style={{width:'50px'}} className="me-2 avatar-sm rounded-circle"
                                 src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt="Mario Avatar"/>
                            <div>
                                <h5 className="card-title mb-0"><a href="#"> {idea?.user?.name}
                                </a></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="card-body">
                    <p className="fs-6 fw-light text-muted">
                        {idea?.content}
                    </p>
                    <div className="d-flex justify-content-between">
                        <div>
                            <a href="#" className="fw-light nav-link fs-6"> <span className="fas fa-heart me-1">
                                        </span> 0 </a>
                        </div>
                        <div>
                                    <span className="fs-6 fw-light text-muted"> <span className="fas fa-clock"> </span>

                                        {idea?.display_created_at} </span>
                        </div>
                    </div>
                    <div>
                        <PostComment setReload={setReload} idea={idea}/>
                        <hr/>
                        {
                            idea?.comment ? idea.comment.map((commemt) => <Comment key={commemt.id} commemt={commemt}/>) : ""
                        }
                    </div>
                </div>
            </div>
        </div>
    </>
}

export default Idea;
