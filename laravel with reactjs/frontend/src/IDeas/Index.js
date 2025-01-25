import CreateIdea from "./CreateIDea";
import Idea from "./Idea";
import useAxios from "../axios";
import {useLayoutEffect, useState} from "react";
import {useConfigGlobal} from "../Config/Config";
import Paginator from "../Layout/paginator";

const Index = () => {
    const axios = useAxios();

    const [ideas, setIdeas] = useState(null)
    const [reload, setReload] = useState(false)
    const [param, setParam] = useState({})
    const [paginate, setPaginate] = useState(null);
    const CONFIG = useConfigGlobal();

    useLayoutEffect(() => {
        if (CONFIG.keySearch !== "") {
            setParam({"key_search": CONFIG.keySearch});
            setReload((val) => !val);
        }
    }, [CONFIG.search]);

    useLayoutEffect(function () {
        CONFIG.handleLoading(true)
        axios.get("/api/get-ideas", param)
            .then(function (resp) {
                setIdeas(resp?.data?.ideas ?? null);
                setPaginate(resp?.data?.pagination ?? null);
            }).finally(() => {
            CONFIG.handleLoading(false)
            // const timer = setTimeout(() => {
            //     CONFIG.handleLoading(false)
            // }, 2000);
            // return () => clearTimeout(timer);
        })

    }, [reload])

    const handleParam = (obj = {}) => {
        setParam(obj);
        setReload((val) => !val);
    }

    return <>
        <CreateIdea setReload={setReload}/>
        <hr/>
        {
            ideas !== null ? ideas.map((idea) => <Idea  key={idea.id}  idea={idea} setReload={setReload}/>) : ""
        }
        <Paginator links={paginate} setParam={handleParam}/>
    </>
}

export default Index;