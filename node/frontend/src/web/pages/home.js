import React from "react";
import { motion } from "framer-motion";

const Home = ({ darkMode }) => {
    const services = [
        { title: "Floor Planning", desc: "Strategic space management for maximum flow.", icon: "📐" },
        { title: "Vendor Sourcing", desc: "Connecting you with top-tier booth builders.", icon: "🤝" },
        { title: "Digital Integration", desc: "Hybrid event solutions and custom event apps.", icon: "🌐" },
    ];

    // 🔥 Simplified + intuitive actions
    const actions = [
        {
            title: "Host an Event",
            desc: "Create, manage, and showcase your event or brand.",
            color: "from-purple-500 to-indigo-600",
            icon: "🚀"
        },
        {
            title: "Explore Events",
            desc: "Discover events, exhibitors, and innovations.",
            color: "from-blue-500 to-cyan-500",
            icon: "🔍"
        }
    ];

    return (
        <main>
            {/* Services Section */}
            <section className="py-20 px-8 max-w-7xl mx-auto">
                <div className="grid md:grid-cols-3 gap-8">
                    {services.map((service, index) => (
                        <motion.div
                            key={index}
                            whileHover={{ y: -10 }}
                            className={`p-10 rounded-3xl border ${darkMode
                                ? "bg-gray-800 border-gray-700"
                                : "bg-white border-gray-100"
                                } shadow-2xl transition-all group`}
                        >
                            <div className="text-4xl mb-4 group-hover:scale-125 transition-transform inline-block">
                                {service.icon}
                            </div>
                            <h4 className="text-2xl font-bold mb-3">
                                {service.title}
                            </h4>
                            <p className="opacity-60 leading-relaxed">
                                {service.desc}
                            </p>
                            <motion.div className="mt-6 h-1 w-0 bg-blue-500 group-hover:w-full transition-all duration-500" />
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* Stats Section */}
            <section
                className={`py-16 ${darkMode ? "bg-gray-800/50" : "bg-blue-600"
                    } text-white text-center`}
            >
                <div className="grid md:grid-cols-3 gap-10 max-w-5xl mx-auto">
                    {[
                        { val: "500+", label: "Events Managed" },
                        { val: "12M+", label: "Attendees Yearly" },
                        { val: "Global", label: "24 Country Reach" }
                    ].map((stat, i) => (
                        <div key={i}>
                            <div className="text-5xl font-black">
                                {stat.val}
                            </div>
                            <div className="opacity-70">{stat.label}</div>
                        </div>
                    ))}
                </div>
            </section>

            {/* ACTION BUTTONS */}
            <section className="py-24 px-8 max-w-7xl mx-auto">
                <h2
                    className={`text-4xl font-black text-center mb-12 ${darkMode ? "text-white" : "text-gray-900"
                        }`}
                >
                    Join the <span className="text-blue-500">Network</span>
                </h2>

                <div className="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    {actions.map((action, idx) => (
                        <motion.button
                            key={idx}
                            whileHover={{ scale: 1.04 }}
                            whileTap={{ scale: 0.97 }}
                            className={`relative overflow-hidden group p-8 rounded-2xl text-left transition-all shadow-xl bg-gradient-to-br ${action.color}`}
                        >
                            {/* Glow Effect */}
                            <div className="absolute -right-6 -top-6 w-28 h-28 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all" />

                            <div className="relative z-10 flex flex-col h-full justify-between">
                                <div>
                                    <span className="text-3xl mb-4 block">
                                        {action.icon}
                                    </span>
                                    <h3 className="text-2xl font-bold text-white mb-1">
                                        {action.title}
                                    </h3>
                                    <p className="text-white/80 text-sm">
                                        {action.desc}
                                    </p>
                                </div>

                                {/* CTA */}
                                <div className="mt-8 flex items-center justify-between text-white font-bold">
                                    <span className="opacity-80 group-hover:opacity-100 transition">
                                        Get Started
                                    </span>

                                    <motion.span
                                        animate={{ x: [0, 6, 0] }}
                                        transition={{
                                            repeat: Infinity,
                                            duration: 1.2,
                                            ease: "easeInOut"
                                        }}
                                        className="ml-2"
                                    >
                                        →
                                    </motion.span>
                                </div>
                            </div>
                        </motion.button>
                    ))}
                </div>
            </section>
        </main>
    );
};

export default Home;