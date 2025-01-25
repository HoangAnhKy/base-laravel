import useAxios from "../axios";
import {useConfigGlobal} from "../Config/Config";
import {useState} from "react";

const PostComment = ({setReload, idea}) => {
    const [contentComment, setContentComment] = useState("");
    const axios = useAxios();
    const config = useConfigGlobal()
    const postComment = () => {
        const data = {
            content_comment: contentComment,
            user_comment: config?.userLogin?.id ?? null,
            idea_id: idea?.id ?? null
        }
        axios.post("api/comment", data)
            .then(function (resp) {
                config.notification(resp?.data?.message)
                setReload((val) => !val)
            }).catch(function (error) {
            config.notification(error?.response?.data?.message, "danger")
        })
    }
    return <>
        <div className="mb-3">
            <textarea className="fs-6 form-control" rows="1" value={contentComment}
                      onChange={(e) => setContentComment(e.target.value)}></textarea>
        </div>
        <div>
            <button className="btn btn-primary btn-sm" onClick={postComment}> Post Comment</button>
        </div>
    </>
}

export default PostComment;