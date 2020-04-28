#!/usr/bin/env node

/**
 * Salon de discussion
 */

'use strict';

const express = require('express')
  , app = express()
  , server = require('http').createServer(app)
  , io = require('socket.io')(server)
  , port = process.env.PORT || 6667
  , fs = require('fs')
  , ini = require('ini')
  , mysql = require('mysql');

const config = ini.parse(fs.readFileSync('../../conf/conf.ini', 'utf-8'));

const db = mysql.createConnection({
  host: config.database.host,
  user: config.database.user,
  password: config.database.pass,
  database: config.database.name,
});

db.connect();

server.listen(port, () => {
  console.log('Server listening at port %d', port);
});

let numUsers = 0;

// connexion d'un nouvel user
io.on('connection', (socket) => {
  let addedUser = false;

  // réception d'un nouveau message
  socket.on('new message', (data) => {
    console.log('new message');
    socket.broadcast.emit('new message', {
      userName: socket.userName,
      message: data,
    });
  });

  // réception d'un 'add user'
  socket.on('add user', (userName) => {
    console.log('add user');
    if (addedUser) {
      return;
    }

    socket.userName = userName;
    ++numUsers;
    addedUser = true;
    socket.emit('login', {
      numUsers: numUsers,
    });
    // echo globally (all clients) that a person has connected
    socket.broadcast.emit('user joined', {
      userName: socket.userName,
      numUsers: numUsers,
    });
  });

  // when the client emits 'typing', we broadcast it to others
  socket.on('typing', () => {
    console.log('typing');
    socket.broadcast.emit('typing', {
      userName: socket.userName,
    });
  });

  // when the client emits 'stop typing', we broadcast it to others
  socket.on('stop typing', () => {
    console.log('stop typing');
    socket.broadcast.emit('stop typing', {
      userName: socket.userName,
    });
  });

  // when the user disconnects.. perform this
  socket.on('disconnect', () => {
    console.log('disconnect');
    if (addedUser) {
      --numUsers;

      // echo globally that this client has left
      socket.broadcast.emit('user left', {
        userName: socket.userName,
        numUsers: numUsers,
      });
    }
  });
});

// fonctions DB

function findLastEvents() {
  const query = 'SELECT ts, room, user, type, message FROM chat_event ORDER BY ts ASC';
  db.query(query);
}

function userJoinRoom (user, room) {
  const query = 'INSERT INTO chat_room_user (room, user) VALUES(%s,%s)';
  db.query(query);
}

function userLeaveRoom (user, room) {
  const query = 'DELETE FROM chat_room_user WHERE room = %s AND user = %s';
  db.query(query);
}

function findUsersByRoom (room) {
  const query = 'SELECT user FROM chat_room_user WHERE room = %s';
  db.query(query);
}

function addEvent (type, name, body) {
  db.query('INSERT INTO chat_event (room, type, name, body) VALUES()', (error, results, fields) => {
    if (error) {
      throw error;
    };
  });
}
