const { now } = require('lodash');
var request = require('request');
const connection = require('./connection');
const moment = require('moment-timezone');
// const crypto = require ("crypto");

// const algorithm = "aes-256-cbc";
// const initVector = "~OC+b$&!?HJ$%@@E";
// const Securitykey = "~OC+b$&!?HJ$%@@E^%@$$Ujs+d$$OC@!";

function decodeString(string, callback) {
    // var decipher = crypto.createDecipheriv(algorithm, Securitykey, initVector);
    // var decryptedData = decipher.update(string, 'base64', 'utf8');
    // decryptedData += decipher.final();
    // callback(decryptedData);
}

function sendPushNotification(token, title, message, user_id, from_user_id) {
    // var query = "SELECT * FROM users WHERE id = '" + user_id + "'";
    // connection.query(query, function (err, results, fields) {
    //     if (err) {
    //         return false;
    //     }
    //     if (results.length != 0) {
    //         results.forEach((user) => {
    //             var profile_url = '';
    //             if (user.profile_image) {
    //                 profile_url = process.env.APP_URL + '/storage/profile/' + user.profile_image;
    //             } else {
    //                 profile_url = process.env.APP_URL + '/assets/img/default.png';
    //             }
    //             var query1 = "SELECT * FROM users WHERE id = '" + from_user_id + "'";
    //             connection.query(query1, function (from_user_err, from_user_results, fields) {
    //                 if (from_user_err) {
    //                     return false;
    //                 }
    //                 if (from_user_results.length != 0) {
    //                     from_user_results.forEach((from_user) => {
    //                         var from_profile = '';
    //                         if (from_user.profile_image) {
    //                             from_profile = process.env.APP_URL + '/storage/profile/' + from_user.profile_image;
    //                         } else {
    //                             from_profile = process.env.APP_URL + '/assets/img/default.png';
    //                         }
    //                         var options = {
    //                             'method': 'POST',
    //                             'url': 'https://fcm.googleapis.com/fcm/send',
    //                             'headers': {
    //                                 'Authorization': 'key=' + process.env.FIREBASE_SERVER_KEY,
    //                                 'Content-Type': 'application/json'
    //                             },
    //                             'body': JSON.stringify({
    //                                 "to": token,
    //                                 "notification": {
    //                                     "title": 'New message from : ' + title,
    //                                     "body": message
    //                                 },
    //                                 'data': {
    //                                     "title": 'New message from : ' + title,
    //                                     "body": message,
    //                                     "user_id": from_user.id,
    //                                     "name": from_user.name,
    //                                     "company_name" : from_user.company_name,
    //                                     "profile_url" : from_profile,
    //                                 }
    //                             })
                    
    //                         };
    //                         request(options, function (error, response) {
    //                             if (error) throw new Error(error);
    //                             console.log('Notification Sent : ', response.body);
    //                         });
    //                     });
    //                 }
    //             });
    //         });
    //     }
    // });
}

module.exports = {
    
    findUserGroup: function (group_id, callback) {
        var query = "SELECT * FROM chat_group_members WHERE group_id = " + group_id;
        connection.query(query, function (err, results, fields) {
            if (err) {
                callback(0, '');
            }

            if (Array.isArray(results)) {
                // removal by for loop
                let finalResults = [];
                const resultsLength = results.length;
                for (let index = 0; index < resultsLength; index++) {
                    finalResults.push(results[index]['user_id']);
                }

                if (finalResults.length > 0) {
                    callback(1, finalResults);
                }

                // callback(0, '');
                // return resolve(finalResults);
            } else {
                callback(0, '');
            }
        });
    },
    
    finduserSocket: function (user_id, callback) {
        console.log('finduserSocket called user_id = ',user_id);
        var query = "SELECT * FROM chat_connections WHERE user_id = " + user_id;
        connection.query(query, function (err, results, fields) {
            if (err) {
                console.log('finduserSocket calling error');
                callback(0, '');
            }

            if (Array.isArray(results)) {
                let finalResults = [];
                const resultsLength = results.length;
                for (let index = 0; index < resultsLength; index++) {
                    finalResults.push({...results[index]});
                }

                if (finalResults.length > 0) {
                    callback(1, finalResults[0].socket_id);
                }

                //callback(0, '');
            } else {
                callback(0, '');
            }
        });
    },

    findVendorUserSockets: function (user_ids, callback) {
        if (!Array.isArray(user_ids)) {
            callback(0, []);
        }
        var query = "SELECT * FROM chat_connections WHERE user_id IN ('" + user_ids.join("','") + "') OR vendor_id IN ('" + user_ids.join("','") + "')" ;
        console.log('findVendorUserSockets called => ',query);
        connection.query(query, function (err, results, fields) {
            if (err) {
                callback(0, []);
            }

            if (Array.isArray(results)) {
                let finalResults = [];
                const resultsLength = results.length;
                for (let index = 0; index < resultsLength; index++) {
                    finalResults.push({...results[index]});
                }
                console.log('finalResults', finalResults[0])
                if (finalResults.length > 0) {
                    callback(1, finalResults);
                }
                callback(0, []);
            } else {
                callback(0, []);
            }
        });
    },
    
    
    // insert user socket id
    userConnection: function (user_id, socket_id) {
        console.log('userConnection called');
        var query = "SELECT * FROM chat_connections WHERE socket_id = '" + socket_id + "'";
        connection.query(query, function (err, result, fields) {
            if (err) {
                console.log('userConnection err', err);
                return false;
            }

            var datetime = new Date();
            var now = datetime.toISOString().replace('Z', ' ').replace('T', ' ').trim();
            if (result.length == 0) {
                // var query1 = "INSERT INTO chat_connections(user_id, admin_id, socket_id) VALUES ("+ user_id +", 0, '" + socket_id + "')";
                var query1 = "INSERT INTO chat_connections(user_id,vendor_id, socket_id, created_at, updated_at) VALUES ('"+user_id+"','"+user_id+"','" + socket_id + "', '" + now + "', '" + now + "')";
                connection.query(query1, function (err, result, fields) {
                    if (err) {
                        console.log('userConnection query1 err', err);
                        return false;
                    }
                    return true;
                });
            } else {
                return true;
            }
            return true;
        });
    },

    vendorConnection: function (user_id, socket_id) {
        var query = "SELECT * FROM chat_connections WHERE socket_id = '" + socket_id + "'";
        console.log('vendorConnection called');
        connection.query(query, function (err, result, fields) {
            if (err) {
                console.log('vendorConnection err', err);
                return false;
            }
            var datetime = new Date();
            var now = datetime.toISOString().replace('Z', ' ').replace('T', ' ').trim();
            if (result.length == 0) {
                var query1 = "INSERT INTO chat_connections(user_id,vendor_id, socket_id, created_at, updated_at) VALUES ('"+user_id+"','"+user_id+"','" + socket_id + "', '" + now + "', '" + now + "')";
                connection.query(query1, function (err, result, fields) {
                    if (err) {
                        console.log('vendorConnection query1 err', err);
                        return false;
                    }
                    return true;
                });
            } else {
                return true;
                // var query1 = "UPDATE chat_connections SET socket_id = '" + socket_id + "', updated_at=now() WHERE vendor_id = " + user_id;
                // connection.query(query1, function (err, result, fields) {
                //     console.log('err', err);
                //     return true;
                // });
            }
            return true;
        });
    },

    storeMessage: function (message, socket_id, to, from, uuid, documents='', callback) {
        console.log('storeMessage function called');
        message = message.trim();
        var datetime = new Date();
        var now = datetime.toISOString().replace('Z', ' ').replace('T', ' ').trim();
        var query = 'INSERT INTO chat_msgs(`message`, `socket_id`, `user_id`, `from`, `created_at`, `updated_at`, `unique_id`, `is_msg_encrypted`)';
            query += ' VALUES("'+ message +'", "'+ socket_id +'", "'+ to.id +'", "'+ from.id +'", "' + now + '", "' + now + '", "'+ uuid +'", 1)';
            
            console.log("insert chat = " +to);
        if (message == '' && (typeof documents == 'undefined' || documents == [])) {
            callback(false, []);
            return false;
        }
        if (message != '') {
            var from_user_query = "SELECT * FROM users WHERE id = '" + from.id + "'";
            var from_user_name = 'Unknown user';
            // console.log('from_user_query : ', from_user_query);
            connection.query(from_user_query, function (err, results, fields) {
                console.log('message store result: ' + results);
                if (!err) {
                    if (results.length != 0) {
                        results.forEach((element) => {
                            from_user_name = element.name;
                            
                            console.log("From user name: " + from_user_name);
                        });
                    }
                } else {
                    console.log("from_user_query Error: " + err);
                }
            });
            
            console.log("message store query = "+ query);
            // var fcm_tokens_query = "SELECT * FROM fcm_tokens WHERE user_id = '" + to.id + "'";
            // console.log('fcm_tokens_query : ', fcm_tokens_query);
            // connection.query(fcm_tokens_query, function (err, results, fields) {
            //     if (!err) {
            //         if (results.length != 0) {
            //             results.forEach((element) => {
            //                 decodeString(message, function(decode_message) {
            //                     sendPushNotification(element.token, from_user_name, decode_message, to.id, from.id)
            //                 });
            //             });
            //         }
            //     } else {
            //         console.log("fcm_tokens_query Error: " + err);
            //     }
            // });
        }
        connection.query(query, function (err, query_results, fields) {
            if (err) {
                console.log('storeMessage query err', err);
                callback(false, []);
            }
            let finalResults = [];
            var finalDocuments = [];
            if (Array.isArray(documents) || typeof documents == 'object') {
                documents.forEach(element => {
                    var datetime = new Date();
                    var now = datetime.toISOString().replace('Z', ' ').replace('T', ' ').trim();
                    var query3 = 'INSERT INTO chat_documents(`chat_msg_id`, `document`, `created_at`, `updated_at`)';
                    query3 += ' VALUES("'+ query_results.insertId +'", "'+ element.name +'", "' + now + '", "' + now + '")';
                    connection.query(query3, function (err, doc_result, fields) {
                        if (err) {
                            console.log('storeMessage documents err', err);
                            callback(false, []);
                        }
                        var query4 = 'SELECT * FROM chat_documents WHERE chat_documents.id = ' + doc_result.insertId;
                        connection.query(query4, function (err, doc_results, fields) {
                            if (err) {
                                console.log('storeMessage query4 err', err);
                                callback(false, []);
                            }
                            doc_results[0].document_url = process.env.APP_URL + '/storage/chats/' + from.id + '/' + doc_results[0].document;
                            finalDocuments.push({...doc_results[0]});
                            console.log('finalDocuments => ', finalDocuments);
                        })
                    });
                });
            }
            // console.log('1');
            console.log(query_results);
            var last_insert_id = query_results.insertId;
            console.log("last_insert_id = " + last_insert_id);
            var query1 = "SELECT chat_msgs.*, users.image as profile_image FROM chat_msgs LEFT JOIN users ON users.id = chat_msgs.user_id WHERE chat_msgs.id = " + query_results.insertId;
            console.log("Query to get message from chat_msgs tbl  = " + query1);
            connection.query(query1, function (err, results, fields) {
                if (err) {
                    console.log('storeMessage query1 err', err);
                    callback(false, []);
                }
                if (Array.isArray(results)) {
                    // removal by for loop
                    // console.log(results);
                    const resultsLength = results.length;
                    const today = new moment();
                    for (let index = 0; index < resultsLength; index++) {
                        // var timedifference = new Date().getTimezoneOffset();
                        // moment.tz(results[index].created_at, 'UTC').fromNow()
                        results[index].time_diff =  moment().format('HH:mm');
                        results[index].display_time =  moment.utc(moment.utc().format()).local().format('HH:mm');
                        finalResults.push({...results[index]});
                    }
                    // console.log('finalResults[0].documents => ', finalDocuments);
                    finalResults[0].documents = finalDocuments;
                    // console.log(finalResults[0]);
                    if (finalResults[0].profile_image) {
                        finalResults[0].from_user_profile_url = process.env.APP_URL + '/storage/profile/' + finalResults[0].profile_image;
                    } else {
                        finalResults[0].from_user_profile_url = process.env.APP_URL + '/images/icon/user_img.png';
                    }
                    var query2 = "SELECT * FROM users WHERE id = " + finalResults[0].from;
                    connection.query(query2, function (err, results, fields) {
                        console.log("To track profile_photo_path img = ",results[0].profile_image);
                        if (results[0].profile_image) {
                            finalResults[0].to_user_profile_url = process.env.APP_URL + '/storage/profile/' + results[0].profile_image;
                        } else {
                            finalResults[0].to_user_profile_url = process.env.APP_URL + '/images/icon/user_img.png';
                        }
                    });
                    console.log("finalResults =",finalResults);
                    callback(true, finalResults[0]);
                }
            });
        });
    },
    storeGroupMessage: function (message, message_type, socket_id, group, from, uuid, documents, callback) {
        message = message.trim();
        var datetime = new Date();
        var now = datetime.toISOString().replace('Z', ' ').replace('T', ' ').trim();
        var query = 'INSERT INTO chat_msgs(`message`, `socket_id`, `user_id`, `from`, `group_id`,`created_at`, `updated_at`, `unique_id`, `message_type`, `is_msg_encrypted`)';
            query += ' VALUES("'+ message +'", "'+ socket_id +'", "'+ from.id +'", "'+ from.id +'", "'+ group.id +'", "' + now + '", "' + now + '", "'+ uuid +'", "' + message_type + '", 1)';
        if (message == '' && (typeof documents == 'undefined' || documents == [])) {
            callback(false, []);
            return false;
        }
        if (message != '') {
            var from_user_query = "SELECT * FROM users WHERE id = '" + from.id + "'";
            var from_user_name = 'Unknown user';
            console.log('from_user_query : ', from_user_query);
            connection.query(from_user_query, function (err, results, fields) {
                if (!err) {
                    if (results.length != 0) {
                        results.forEach((element) => {
                            from_user_name = element.name;
                        });
                    }
                } else {
                    console.log("from_user_query Error: " + err);
                }
            });
            var query_group = "SELECT * FROM chat_group_members WHERE group_id = " + group.id + " AND user_id != " + from.id;
            connection.query(query_group, function (err, results, fields) {
                if (err) {
                    console.log("from_group_query Error: " + err);
                }

                // if (Array.isArray(results)) {
                //     // removal by for loop
                //     let user_ids = [];
                //     const resultsLength = results.length;
                //     for (let index = 0; index < resultsLength; index++) {
                //         user_ids.push(results[index]['user_id']);
                //     }

                //     if (user_ids.length > 0) {
                //         user_ids.forEach((ele)=> {
                //             var fcm_tokens_query = "SELECT * FROM fcm_tokens WHERE user_id = '" + ele + "'";
                //             console.log('fcm_tokens_query : ', fcm_tokens_query);
                //             connection.query(fcm_tokens_query, function (err, results, fields) {
                //                 if (!err) {
                //                     if (results.length != 0) {
                //                         results.forEach((element) => {
                //                             decodeString(message, function(decode_message) {
                //                                 sendPushNotification(element.token, group.group_name, from_user_name + ': ' + decode_message, ele, from.id,1, group.id)
                //                             });
                //                         });
                //                     }
                //                 } else {
                //                     console.log("fcm_tokens_query Error: " + err);
                //                 }
                //             });
                //         });
                //     }
                // }
            });
        }
        console.log('query', query);
        connection.query(query, function (err, query_results, fields) {
            if (err) {
                console.log('storeMessage query err', err);
                callback(false, []);
            }
            let finalResults = [];
            var finalDocuments = [];
            if (Array.isArray(documents) || typeof documents == 'object') {
                documents.forEach(element => {
                    var datetime = new Date();
                    var now = datetime.toISOString().replace('Z', ' ').replace('T', ' ').trim();
                    var query3 = 'INSERT INTO chat_documents(`chat_msg_id`, `document`, `created_at`, `updated_at`)';
                    query3 += ' VALUES("'+ query_results.insertId +'", "'+ element.name +'", "' + now + '", "' + now + '")';
                    connection.query(query3, function (err, doc_result, fields) {
                        if (err) {
                            console.log('storeMessage documents err', err);
                            callback(false, []);
                        }
                        var query4 = 'SELECT * FROM chat_documents WHERE chat_documents.id = ' + doc_result.insertId;
                        connection.query(query4, function (err, doc_results, fields) {
                            if (err) {
                                console.log('storeMessage query4 err', err);
                                callback(false, []);
                            }
                            doc_results[0].document_url = process.env.APP_URL + '/storage/chats/' + from.id + '/' + doc_results[0].document;
                            finalDocuments.push({...doc_results[0]});
                            console.log('finalDocuments => ', finalDocuments);
                        })
                    });
                });
            }
            var query1 = "SELECT chat_msgs.*, users.image as from_user_profile FROM chat_msgs LEFT JOIN users ON users.id = chat_msgs.user_id WHERE chat_msgs.id = " + query_results.insertId;
            connection.query(query1, function (err, results, fields) {
                if (err) {
                    console.log('storeMessage query1 err', err);
                    callback(false, []);
                }
                if (Array.isArray(results)) {
                    // removal by for loop
                    const resultsLength = results.length;
                    const today = new moment();
                    for (let index = 0; index < resultsLength; index++) {
                        // var timedifference = new Date().getTimezoneOffset();
                        // moment.tz(results[index].created_at, 'UTC').fromNow()
                        results[index].time_diff =  moment().format('HH:mm');
                        results[index].display_time =  moment.utc(moment.utc().format()).local().format('HH:mm');
                        results[index].group_id = group.id;
                        finalResults.push({...results[index]});
                    }
                    // console.log('finalResults[0].documents => ', finalDocuments);
                    finalResults[0].documents = finalDocuments;
                    // console.log(finalResults[0]);
                    if (finalResults[0].from_user_profile) {
                        finalResults[0].from_user_profile_url = process.env.APP_URL + '/storage/profile/' + finalResults[0].from_user_profile;
                    } else {
                        finalResults[0].from_user_profile_url = process.env.APP_URL + '/images/icon/user_img.png';
                    }
                    var query2 = "SELECT * FROM users WHERE id = " + finalResults[0].from;
                    connection.query(query2, function (err, results, fields) {
                        if (results[0].profile_photo_path) {
                            finalResults[0].to_user_profile_url = process.env.APP_URL + '/storage/profile/' + results[0].profile_photo_path;
                        } else {
                            finalResults[0].to_user_profile_url = process.env.APP_URL + '/images/icon/user_img.png';
                        }
                    });
                    callback(true, finalResults[0]);
                }
            });
        });
    },
    sentMessage: function (id, callback) {
        var query = "UPDATE chat_msgs SET status = 2 WHERE id = " + id;
        connection.query(query, function (err, results, fields) {
            console.log('sentMessage');
            if (err) {
                callback(false);
            }
            callback(true);
        });
    },
    
    deleteConnection: function (socket_id, callback) {
        var query = "DELETE FROM chat_connections WHERE socket_id = '"+ socket_id +"'";
        connection.query(query, function (err, results, fields) {
            if (err) {
                callback(false);
            }
            callback(true);
        });
    },
    
    sentMesgStatus: function (uuids, callback) {
        var query = "UPDATE chat_msgs SET status = 2 where unique_id IN (" + uuids + ")";
        connection.query(query, function (err, results, fields) {
            console.log('sentMesgStatus');
            if (err) {
                callback(false);
            }
            callback(true);
        });
    },

    messageSentStatus: function (uuid, callback) {
        var query = "UPDATE chat_msgs SET status = 2 where unique_id = '"+ uuid +"'";
        connection.query(query, function (err, results, fields) {
            console.log('messageSentStatus');
            if (err) {
                callback(false);
            }
            callback(true);
        });
    },
}
