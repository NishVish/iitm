const express = require('express');
const router = express.Router();

// @route   GET api/events
// @desc    Get all upcoming events with city and branding data
router.get('/', (req, res) => {
    const events = [
        {
            id: 1,
            city: "Mumbai",
            title: "Bollywood Tech Summit",
            date: "April 10, 2026",
            location: "Juhu, Mumbai",
            type: "Tech",
            image: "🎬",
            color: "from-orange-500 to-red-600"
        },
        {
            id: 2,
            city: "Mumbai",
            title: "Finance Expo",
            date: "May 12, 2026",
            location: "BKC, Mumbai",
            type: "Finance",
            image: "💰",
            color: "from-blue-500 to-indigo-600"
        },
        {
            id: 3,
            city: "Bengaluru",
            title: "Garden City Startup Fest",
            date: "June 05, 2026",
            location: "Indiranagar, BLR",
            type: "Startup",
            image: "🦄",
            color: "from-green-400 to-cyan-500"
        },
        {
            id: 4,
            city: "Delhi",
            title: "Heritage Food Walk",
            date: "July 01, 2026",
            location: "Chandni Chowk, Delhi",
            type: "Food",
            image: "🥘",
            color: "from-yellow-500 to-orange-600"
        },
        {
            id: 5,
            city: "Hyderabad",
            title: "Cyber City Con",
            date: "August 15, 2026",
            location: "HITEC City, HYD",
            type: "Cybersecurity",
            image: "🛡️",
            color: "from-slate-700 to-slate-900"
        },
        {
            id: 6,
            city: "Chennai",
            title: "Automotive Expo",
            date: "September 20, 2026",
            location: "OMR, Chennai",
            type: "Auto",
            image: "🏎️",
            color: "from-red-600 to-black"
        },
        {
            id: 7,
            city: "Kolkata",
            title: "Art & Literature Meet",
            date: "October 05, 2026",
            location: "Park Street, KOL",
            type: "Arts",
            image: "📚",
            color: "from-yellow-600 to-brown-700"
        },
        {
            id: 8,
            city: "Pune",
            title: "Education & Tech Fair",
            date: "November 12, 2026",
            location: "Kothrud, Pune",
            type: "Education",
            image: "🎓",
            color: "from-purple-500 to-blue-600"
        },
        {
            id: 9,
            city: "Ahmedabad",
            title: "Industrial Growth Summit",
            date: "December 02, 2026",
            location: "SG Highway, ABD",
            type: "Business",
            image: "🏭",
            color: "from-blue-400 to-blue-800"
        }
    ];

    res.status(200).json({
        success: true,
        count: events.length,
        data: events
    });
});

module.exports = router;