const express = require("express");
const app = express();
const { createServer } = require("http");
const { Server } = require("socket.io");

const httpServer = createServer(app); // ✅ phải truyền app vào
const io = new Server(httpServer, {
    cors: {
        origin: "*", // hoặc domain Laravel nếu muốn bảo mật
        methods: ["GET", "POST"],
    }
});

httpServer.listen(6002, "0.0.0.0", () => {
    console.log("🚀 Socket.IO server running at http://0.0.0.0:6002");
});

io.on("connection", (socket) => {
    console.log("🔌 Client connected:", socket.id);

    socket.on("disconnect", () => {
        console.log("❌ Client disconnected:", socket.id);
    });
});

// Route test 
app.get("/", (req, res) => {
    res.send("NodeJS Socket.IO Server đang chạy trên cổng 6002 🚀");
});

app.post("/broadcast", (req, res) => {
    const { channel, event, data } = req.body;

    console.log("📦 Order from Laravel:", data.id);

    io.emit(`${channel}:${event}`, data);

    res.json({ ok: true });
});


app.use(express.json());
