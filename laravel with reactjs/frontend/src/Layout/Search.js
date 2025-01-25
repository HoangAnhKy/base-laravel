import {useConfigGlobal} from "../Config/Config";

const Search = () => {

    const CONFIG = useConfigGlobal();
    return <>
        <div className="card">
            <div className="card-header pb-0 border-0">
                <h5 className="">Search</h5>
            </div>
            <div className="card-body">
                <input placeholder="..." value={CONFIG.keySearch} onChange={(e) => CONFIG.handleKeySearch(e.target.value)} className="form-control w-100" type="text"
                       id="search" />
                <button className="btn btn-dark mt-2" onClick={CONFIG.handleBtnSearch}> Search</button>
            </div>
        </div>
    </>
}

export default Search;