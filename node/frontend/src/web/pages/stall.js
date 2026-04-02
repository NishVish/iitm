import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";

const Stall = () => {
    const navigate = useNavigate();
    const [rotate, setRotate] = useState({ x: 10, y: 0 });
    const [sizeIndex, setSizeIndex] = useState(0); // 0: 4sqm, 1: 6sqm, 2: 9sqm
    const [branding, setBranding] = useState({ wall: null, desk: null });

    const stallConfigs = [
        { name: "4sqm", width: 300, depth: 300, label: "Compact Booth" },
        { name: "6sqm", width: 450, depth: 300, label: "Standard Space" },
        { name: "9sqm", width: 450, depth: 450, label: "Premium Pavilion" }
    ];

    const current = stallConfigs[sizeIndex];

    // Mouse tilt effect
    useEffect(() => {
        const handleMouseMove = (e) => {
            const xRotation = (window.innerHeight / 2 - e.clientY) / 30;
            const yRotation = (e.clientX - window.innerWidth / 2) / 30;
            setRotate({ x: xRotation + 5, y: yRotation });
        };
        window.addEventListener("mousemove", handleMouseMove);
        return () => window.removeEventListener("mousemove", handleMouseMove);
    }, []);

    // Handle Image Uploads
    const handleUpload = (e, type) => {
        const file = e.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = (upload) => setBranding(prev => ({ ...prev, [type]: upload.target.result }));
            reader.readAsDataURL(file);
        }
    };

    const changeSize = (dir) => {
        if (dir === 'next') setSizeIndex((prev) => (prev + 1) % 3);
        else setSizeIndex((prev) => (prev - 1 + 3) % 3);
    };

    return (
        <div className="min-h-screen bg-slate-950 flex flex-col items-center justify-center overflow-hidden perspective-1000">

            {/* 3D SCENE */}
            <div
                className="relative transition-all duration-700 ease-in-out"
                style={{
                    width: `${current.width}px`,
                    height: '400px',
                    transformStyle: 'preserve-3d',
                    transform: `rotateX(${rotate.x}deg) rotateY(${rotate.y}deg)`
                }}
            >
                {/* FLOOR */}
                <div
                    className="absolute inset-0 bg-slate-800 border-2 border-slate-700 shadow-2xl"
                    style={{
                        transform: `rotateX(90deg) translateZ(${-current.depth / 2}px)`,
                        height: `${current.depth}px`
                    }}
                ></div>

                {/* BACK WALL (Branding Target) */}
                <div
                    className="absolute inset-0 bg-indigo-900 border-4 border-blue-500/30 flex items-center justify-center overflow-hidden"
                    style={{
                        transform: `translateZ(${-current.depth / 2}px)`,
                        backgroundImage: branding.wall ? `url(${branding.wall})` : 'none',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center'
                    }}
                >
                    {!branding.wall && <h2 className="text-white opacity-20 font-bold text-4xl">BACK WALL</h2>}
                </div>

                {/* SIDE WALLS */}
                <div className="absolute top-0 bottom-0 bg-slate-900 border-blue-500/20"
                    style={{
                        width: `${current.depth}px`,
                        transform: `rotateY(90deg) translateZ(${-current.width / 2}px)`,
                        backgroundImage: branding.wall ? `url(${branding.wall})` : 'none',
                        backgroundSize: 'cover',
                        opacity: 0.8
                    }}>
                </div>

                {/* RECEPTION DESK (Branding Target) */}
                <div
                    className="absolute bottom-4 left-1/2 -translate-x-1/2 w-48 h-24 bg-white shadow-xl flex items-center justify-center overflow-hidden"
                    style={{
                        transform: `translateZ(${current.depth / 4}px)`,
                        backgroundImage: branding.desk ? `url(${branding.desk})` : 'none',
                        backgroundSize: 'cover'
                    }}
                >
                    {!branding.desk && <span className="text-slate-400 text-xs font-bold">DESK BRANDING</span>}
                </div>
            </div>

            {/* CONTROLS OVERLAY */}
            <div className="fixed bottom-10 flex flex-col items-center gap-6 z-50">

                {/* Size Selector Arrows */}
                <div className="flex items-center gap-8 bg-black/50 backdrop-blur-md p-4 rounded-full border border-white/20">
                    <button onClick={() => changeSize('prev')} className="text-white text-2xl hover:text-blue-400">←</button>
                    <div className="text-center min-w-[120px]">
                        <div className="text-white font-bold">{current.name}</div>
                        <div className="text-blue-400 text-[10px] uppercase">{current.label}</div>
                    </div>
                    <button onClick={() => changeSize('next')} className="text-white text-2xl hover:text-blue-400">→</button>
                </div>

                {/* Upload Buttons */}
                <div className="flex gap-4">
                    <label className="cursor-pointer bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-xs transition">
                        UPLOAD WALL BRANDING
                        <input type="file" className="hidden" onChange={(e) => handleUpload(e, 'wall')} />
                    </label>
                    <label className="cursor-pointer bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-xs transition">
                        UPLOAD DESK LOGO
                        <input type="file" className="hidden" onChange={(e) => handleUpload(e, 'desk')} />
                    </label>
                </div>
            </div>

            {/* Exit Button */}
            <button onClick={() => navigate("/")} className="absolute top-10 left-10 text-white/50 hover:text-white transition">
                ← Exit Designer
            </button>
        </div>
    );
};

export default Stall;