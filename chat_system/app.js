var createError = require('http-errors');
var env = require('dotenv').config({path: __dirname + '/.env'})
var express = require('express');
var app = express();
const http = require('https');
const cors = require('cors');
var functions = require('./functions');
var fs = require('fs');


//const server = http.createServer(app);
if (process.env.IS_HTTPS == 'true') {
    const options = {
          key: fs.readFileSync('/etc/letsencrypt/live/peeq.com.au/privkey.pem'),
          cert: fs.readFileSync('/etc/letsencrypt/live/peeq.com.au/fullchain.pem')
    };
    var server = require('https').createServer(options,);
} else {
    var server = require('http').createServer();
}

var io = require('socket.io') (server, {
    cors: {
    origin: '*',
    methods: ['GET', 'POST'],
  }
});



app.use(cors());


function pingOthersForStatus(socket, status) {
    connectedUsers.forEach(element => {
        if (socket.id != element.socketId) {
            socket.broadcast.to(element.socketId).emit('networkStatus', status);
        }
    });
}

let connectedUsers = [];
io.on('connection', (socket) => {
    console.log('Socket connected successfully');

    connectedUsers.forEach(user => {
       socket.emit('networkStatus', { user_id : user.id, status : 1 });
   });
   
   // create socket connection while user connect
   socket.on('create', function(data) {
    if (data.user != undefined) {
        let user = JSON.parse(data.user);
        console.log('123456 = ',user);
        connectedUsers = connectedUsers.filter(item => item.int_glcode != user);
        connectedUsers.push({int_glcode: user, socketId: socket.id});
        
        pingOthersForStatus(socket, { user_id : data.user.id, status : 1 });
        functions.userConnection(data.user.id, socket.id);
        socket.broadcast.to(socket.id).emit("invite", { room:data })
    }
});

    socket.on('vendorCreate', function(data) {
      // let withSocket = getSocketByUserId(data.id);
      connectedUsers = connectedUsers.filter(item => item.id != data.user.id);
      connectedUsers.push({...data.user, socketId: socket.id});
      pingOthersForStatus(socket, { user_id : data.user.id, status : 1 });
      functions.vendorConnection(data.user.id, socket.id);
      socket.broadcast.to(socket.id).emit("invite", { room:data })
  });

    socket.on('disconnect', (() => {
        console.log('disconnect');
        console.log('socket_id', socket.id);
        var disconnectedUsers = connectedUsers.filter(item => item.socketId == socket.id);
        connectedUsers = connectedUsers.filter(item => item.socketId != socket.id);
        functions.deleteConnection(socket.id, function (status) {
            io.emit('updateUserList', connectedUsers)
        });
        disconnectedUsers.forEach(function (user) {
            pingOthersForStatus(socket, { user_id : user.id, status : 0});
        });
    }));

    socket.on('loggedin', function(user) {
        connectedUsers = connectedUsers.filter(item => item.id != user.id);
        connectedUsers.push({...user, socketId: socket.id})
        io.emit('updateUserList', connectedUsers)
    });

    socket.on('vendorMessage', function(data) {
        console.log('vendorMessage called sender id:',data.send);
        functions.finduserSocket(data.send.id, function (status, socket_id) {
            functions.storeMessage(data.message, socket_id, data.send, data.from, data.uuid, data.documents, function (response, result) {
                console.log('Callback function executed. Response:', response, 'Result:', result);
                socket.broadcast.to(socket.id).emit('message_acknowledge', result);
                receiveMessageOnSocket(socket, [data.send.id, data.from.id], result);
            });
            if (status) {
                console.log('socket_id', socket_id);
                socket.broadcast.to(socket_id).emit('message', data);
                functions.messageSentStatus(data.uuid, function (result) {
                    console.log('messageSentStatus', result);
                });
            }
        });
    });
    
    socket.on('vendorGroupMessage', function(data) {
        console.log('vendor Group Message called sender id:',data.send);
        functions.storeGroupMessage(data.message, data.message_type, '', data.send_group, data.from, data.uuid, data.documents, function (response, result) {
            socket.broadcast.to(socket.id).emit('message_acknowledge', result);
            functions.findUserGroup(data.send_group.id, function (status, user_ids) {
                if (status) {
                    receiveMessageOnSocket(socket, user_ids, result);
                }
            });
        });
    });
    
    
    socket.on('sentMesgStatus', function (data) {
        console.log('sentMesgStatus : data', data.uuids);
        functions.sentMesgStatus(data.uuids, function (response) {

        });
    });
        
// catch 404 and forward to error handler
app.use(function (req, res, next) {
    next(createError(404));
});

function receiveMessageOnSocket(socket, user_ids, result) {
    console.log('receiveMessageOnSocket');
    functions.findVendorUserSockets(user_ids, function (status, results) {
        results.forEach(element => {
            socket.broadcast.to(element.socket_id).emit('message', result);
        });
    });
}

    
    socket.on('sentMesgStatus', function (data) {
        console.log('sentMesgStatus : data', data.uuids);
        functions.sentMesgStatus(data.uuids, function (response) {

        });
    });

    socket.on('messageReceive', function(data) {
        console.log('messageReceive : data', data.uuids);
        functions.sentMessage(data.id, function (response) {
            //
        });
    });
    
    socket.on('createGroup', function(data) {
        functions.findUserGroup(data.group_id, function (status, user_ids) {
            if (status) {
                functions.findVendorUserSockets(user_ids, function (status, results) {
                    results.forEach(element => {
                        socket.broadcast.to(element.socket_id).emit('newGroupCreated', data);
                    });
                });
            }
        });
    });
    
    socket.on('changeGroupMember', function(data) {
        if (data.mode == 'group_name_changed') {
            functions.findUserGroup(data.group_id, function (status, user_ids) {
                if (status) {
                    functions.findVendorUserSockets(user_ids, function (status, results) {
                        results.forEach(element => {
                            socket.broadcast.to(element.socket_id).emit('groupMemberChanged', data);
                        });
                    });
                }
            });
        } else if (data.mode == 'member_leave') {
            functions.findVendorUserSockets(Array(data.member_id), function (status, results) {
                results.forEach(element => {
                    socket.broadcast.to(element.socket_id).emit('groupMemberChanged', data);
                });
            });
            functions.findUserGroup(data.group_id, function (status, user_ids) {
                if (status) {
                    functions.findVendorUserSockets(user_ids, function (status, results) {
                        results.forEach(element => {
                            socket.broadcast.to(element.socket_id).emit('groupUpdate', data);
                        });
                    });
                }
            });
        } else if (data.mode == 'group_deleted') {
            functions.findVendorUserSockets(Array(data.member_id), function (status, results) {
                results.forEach(element => {
                    socket.broadcast.to(element.socket_id).emit('groupMemberChanged', data);
                });
            });
        } else {
            functions.findVendorUserSockets(Array(data.member_id), function (status, results) {
                results.forEach(element => {
                    socket.broadcast.to(element.socket_id).emit('groupMemberChanged', data);
                });
            });
            functions.findUserGroup(data.group_id, function (status, user_ids) {
                if (status) {
                    functions.findVendorUserSockets(user_ids, function (status, results) {
                        results.forEach(element => {
                            socket.broadcast.to(element.socket_id).emit('groupUpdate', data);
                        });
                    });
                }
            });
        }
    });
    
})
module.exports = app;
server.listen(8000 ,()=>{
console.log('Server is running...');
});
