require('dotenv').config(); // Load biến môi trường từ file .env
const cors = require('cors')
const express = require("express");
const app = express();
const { createServer } = require("http");
const { Server } = require("socket.io");
const fs = require("fs");
const path = require("path");

// Middleware - Phải đặt trước các route

app.use(cors()); // Cho phép mọi domain hoặc cấu hình cụ thể trong .env
app.use(express.json());
const httpServer = createServer(app);
const io = new Server(httpServer, {
    cors: {
        origin: "*", // Production nên thay bằng domain Laravel
        methods: ["GET", "POST"],
    }
});

// Cơ chế Auto-load Custom Events (Mở rộng không cần sửa file gốc)
const eventsPath = path.join(__dirname, "events");
if (fs.existsSync(eventsPath)) {
    fs.readdirSync(eventsPath).forEach(file => {
        if (file.endsWith(".js")) {
            require(`./events/${file}`)(io);
        }
    });
}

// Socket Connection Logic
io.on("connection", (socket) => {
    console.log("🔌 Client connected:", socket.id);

    // Join room để chat riêng biệt
    socket.on("join", (room) => {
        socket.join(room);
        console.log(`👤 Socket ${socket.id} joined room: ${room}`);
    });

    socket.on("disconnect", () => {
        console.log("❌ Client disconnected:", socket.id);
    });
});

// Route nhận tin nhắn từ Laravel Bridge
app.post("/broadcast", (req, res) => {
    const { channel, event, data } = req.body;

    io.emit(event, data);

    res.json({ ok: true });
});

app.get("/", (req, res) => res.send("Socket server is running..."));

const PORT = process.env.PORT || 6002;
httpServer.listen(PORT, "0.0.0.0", () => {
    console.log(`🚀 Server running at http://0.0.0.0:${PORT}`);
});
