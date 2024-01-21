import React from "react";
import { createRoot } from 'react-dom/client';
import { HashRouter, Routes, Route, Link } from "react-router-dom";

const Home = () => <h1>Home Page</h1>;

const About = () => <h1>About Page</h1>;

const MainRouter = () => {
    return (
        <HashRouter>
            <Link to={'/'}>Home</Link>
            <Link to={'/about'}>About</Link>
            <Routes>
                <Route path="/" element={<Home/>}/>
                <Route path="/about" element={<About/>}/>
            </Routes>
        </HashRouter>
    )
}

createRoot(document.querySelector("#root")).render(<MainRouter />);