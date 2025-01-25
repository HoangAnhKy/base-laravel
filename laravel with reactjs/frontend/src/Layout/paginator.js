import {useState, useEffect} from "react";

const Paginator = ({links, setParam}) => {
    const [linkNext, setLinkNext] = useState(false);
    const [linkPrev, setLinkPrev] = useState(false);

    const [paginate, setPaginate] = useState({paginate: [], label: ""});

    const handleLink = (e) => {
        e.preventDefault();
        let valueHandle = e.target.href;
        let urlMatch = valueHandle.match(/\?(.*)/mg) ?? null;
        if (urlMatch) {
            urlMatch = urlMatch[0].slice(1).split("&");
            const newParam = urlMatch.map((url) => url.split("="));
            setParam(Object.fromEntries(newParam));
        }
    };

    useEffect(() => {
        if (links) {
            const updatedLinks = [...links].slice(1, -1);
            const page = updatedLinks.findIndex((obj) => obj.active);
            const LIMIT = 3;

            let tempPaginate;
            setLinkPrev(true)
            if (updatedLinks.length - LIMIT <= page) {
                tempPaginate = updatedLinks.slice((updatedLinks.length - LIMIT), updatedLinks.length);
                setLinkNext(false);
            } else {
                if (page + 1 > LIMIT) {
                    tempPaginate = updatedLinks.slice(page - 1, page + LIMIT - 1);
                } else {
                    tempPaginate = updatedLinks.slice(0, LIMIT);
                    setLinkPrev(false)
                }
                setLinkNext(true)
            }
            setPaginate({paginate: tempPaginate, label: `show (${page + 1} / ${updatedLinks.length})`});
        }
    }, [links]);

    const prev = links ? links[0] : null;
    const next = links ? links[links.length - 1] : null;

    return (
        <>
            {links && prev && next && links.length > 1 ? (
                <>
                    <p className="text-center mt-3">{paginate.label}</p>
                    <nav aria-label="Page navigation"
                         className="d-flex justify-content-center align-content-center">
                        <ul className="pagination">
                            <li key={"prev"} className={`page-item ${prev.active ? "active" : ""}`}>
                                <a onClick={handleLink} className="page-link" href={prev.url}>
                                    {prev.label}
                                </a>
                            </li>

                            {linkPrev && <li className="page-item"><span className="page-link">...</span></li>}
                            {paginate.paginate.map((link, index) => (
                                <li key={index} className={`page-item ${link.active ? "active" : ""}`}>
                                    <a onClick={handleLink} className="page-link" href={link.url}>
                                        {link.label}
                                    </a>
                                </li>
                            ))}
                            {linkNext && <li className="page-item"><span className="page-link">...</span></li>}
                            <li key={"next"} className={`page-item ${next.active ? "active" : ""}`}>
                                <a onClick={handleLink} className="page-link" href={next.url}>
                                    {next.label}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </>
            ) : (
                ""
            )}
        </>
    );
};

export default Paginator;
