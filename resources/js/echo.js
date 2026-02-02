import Echo from "laravel-echo";
import { io } from "socket.io-client";

// Lấy cấu hình từ biến global hoặc mặc định
const SOCKET_HOST = window.CHAT_CONFIG_HOST || "node.tungocvan.com";

// Khởi tạo trực tiếp client
const socket = io(`${SOCKET_HOST}`, {
    transports: ["websocket", "polling"],
    withCredentials: false,
});

window.io = io;

// Nếu muốn dùng Laravel Echo:
window.Echo = new Echo({
    broadcaster: "socket.io",
    client: io,
    host: `${SOCKET_HOST}`,
});

// Tạo socket client toàn cục
window.socket = io(`${SOCKET_HOST}`, {
    transports: ["websocket", "polling"],
});



socket.on("connect", () => {
    console.log("✅ Socket.IO connected (echo.js):", socket.id);
    console.log("✅SOCKET_HOST: ", SOCKET_HOST );
});

socket.on("disconnect", () => {
    console.log("❌ Socket.IO disconnected (echo.js)");
});


// xem log nodejs: pm2 monit
