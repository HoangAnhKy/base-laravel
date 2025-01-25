import './bootstrap';

import React from 'react';
import ReactDOM from 'react-dom/client';
import App from "@/Components/App.jsx";
import {BrowserRouter} from "react-router-dom";

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min";

const rootElement = document.getElementById('root'); // Đảm bảo khớp với id trong HTML
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(<BrowserRouter>
        <App/>
    </BrowserRouter>);
}
