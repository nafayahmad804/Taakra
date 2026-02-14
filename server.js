import express from 'express';
import http from 'http';
import { Server } from 'socket.io';

const app = express();
const server = http.createServer(app);

const io = new Server(server, {
    cors: {
        origin: ["http://localhost:8000", "http://127.0.0.1:8000"],
        methods: ["GET", "POST"],
        credentials: true
    }
});

const PORT = 3000;

// Store connected users
const users = new Map();
const supportStaff = new Map();

io.on('connection', (socket) => {
    console.log('User connected:', socket.id);

    socket.on('user:join', (data) => {
        users.set(socket.id, {
            id: data.userId,
            name: data.userName,
            email: data.userEmail,
            role: data.role
        });

        if (data.role === 'support' || data.role === 'admin') {
            supportStaff.set(socket.id, data.userId);
            socket.join('support');
        }

        socket.emit('connection:success', { message: 'Connected successfully' });
    });

    socket.on('message:send', (data) => {
        const sender = users.get(socket.id);
        if (!sender) return;

        const message = {
            id: Date.now(),
            userId: sender.id,
            userName: sender.name,
            message: data.message,
            timestamp: new Date().toISOString(),
            senderType: sender.role === 'support' || sender.role === 'admin' ? 'support' : 'user'
        };

        if (sender.role === 'support' || sender.role === 'admin') {
            // send directly to target user
            const targetSocket = Array.from(users.entries()).find(
                ([sid, user]) => user.id === data.targetUserId
            )?.[0];

            if (targetSocket) {
                io.to(targetSocket).emit('message:receive', message);
            }
        } else {
            // send to support room
            io.to('support').emit('message:receive', message);
        }

        socket.emit('message:sent', message);
    });

    socket.on('typing:start', (data) => {
        if (data.targetRoom) {
            socket.to(data.targetRoom).emit('typing:show', {
                userId: users.get(socket.id)?.id,
                userName: users.get(socket.id)?.name
            });
        }
    });

    socket.on('typing:stop', (data) => {
        if (data.targetRoom) {
            socket.to(data.targetRoom).emit('typing:hide', {
                userId: users.get(socket.id)?.id
            });
        }
    });

    socket.on('disconnect', () => {
        users.delete(socket.id);
        supportStaff.delete(socket.id);
        console.log('User disconnected:', socket.id);
    });
});

server.listen(PORT, () => {
    console.log(`Socket.IO server running on port ${PORT}`);
});
