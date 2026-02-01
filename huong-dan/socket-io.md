
# tạo route hay lắng nghe sự kiện trong file server.js
# cấu trúc cơ bản nodejs server.js
```package.json
    {
  "dependencies": {
    "express": "^5.1.0",
    "socket.io": "^4.8.1"
  }
}
```
# tạo project nodejs: npm i
```js
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

    app.use(express.json());

```
# khởi tạo project: pm2 start socket/server.js --name nodejs-server-socketio-flexbiz
# cấu hình nginx để chạy https
# Redirect HTTP -> HTTPS cho node.laravel.tk
http://127.0.0.1:6002 => https://node.laravel.tk
```nginx
server {
    listen 80;
    server_name node.laravel.tk;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name node.laravel.tk;
    ssl_certificate     /etc/.cert/laravel.tk-cert.pem;
    ssl_certificate_key /etc/.cert/laravel.tk-key.pem;
    ssl_protocols       TLSv1.2 TLSv1.3;
    ssl_ciphers         HIGH:!aNULL:!MD5;

    location / {
        proxy_pass http://127.0.0.1:6002;
        proxy_http_version 1.1;

        # WebSocket headers
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";

        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        proxy_read_timeout 600s;
        proxy_send_timeout 600s;
    }
}

```
# cấu hình trên vps thật:
server {
    listen 80;
    server_name node.tungocvan.com;

    location / {
        proxy_pass         http://127.0.0.1:6001;
        proxy_http_version 1.1;

        # WebSocket support
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";

        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        proxy_read_timeout 600s;
        proxy_send_timeout 600s;
    }
}