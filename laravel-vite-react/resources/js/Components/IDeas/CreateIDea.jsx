import {useState} from "react";
import useAxios from "../../axios";
import {useConfigGlobal} from "../Config/Config.jsx";

const CreateIDea = ({setReload}) => {
    const [content, setContent] = useState("");
    const axios = useAxios();
    const config = useConfigGlobal()
    const postIdea = () => {
        const data = {
            content,
            user_post: config?.userLogin?.id ?? null
        }
        axios.post("api/post-idea", data)
            .then(function (resp) {
                config.notification(resp?.data?.message)
                setReload((val) => !val)
            }).catch(function (error) {
            config.notification(error?.response?.data?.message, "danger")
            })
    }
    return <>
        <h4> Share yours ideas </h4>
        <div className="row">
            <div className="mb-3">
                <textarea className="form-control" id="idea" rows="3" value={content}
                          onChange={(e) => setContent(e.target.value)}></textarea>
            </div>
            <div className="">
                <button className="btn btn-dark" type="button" onClick={postIdea}> Share</button>
            </div>
        </div>
    </>
}

export default CreateIDea;
