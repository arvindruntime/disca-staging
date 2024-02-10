let chat_user;
let chat_group;
var page = 1;
var processing = true;
var on_top = false;

//let socket = io(socket_host);
//socket.on('connection');
let socket = io('http://localhost:8000/'); 
//  let socket = io('http://54.189.234.236:8000/'); 
// let socket = io('http://45.90.223.64:3000/');

//const socket = io('https://peeq.com.au/staging:3000', {
 // path: '/socket.io',
 // transports: ['websocket'],
//});

// socket.on('connection', (socket)=>{
//     console.log('connection========', socket);
// }); // Arvind commented on 12-01-2024
//const socket = io('https://peeq.com.au/staging/:3000', {
 // path: 'https://peeq.com.au/staging/:3000',
//});
socket.on('connection');

socket.on('connect_failed', function(status) {
    connectionLost();
});

socket.on( 'disconnect', function() {
    connectionLost();
});

socket.on('error', function(status) {
    connectionLost();
});

socket.on('connect', function(status) {
    connectionBack();
});

function connectionLost() {
    console.log("Connection Lost!");
    $('.msg_head').addClass('bg-danger');
}

function connectionBack() {
console.log('Connection back');
    socket.emit('vendorCreate', { user: from_user });
    $('.msg_head').removeClass('bg-danger');
}

// online offline user status
// socket.on('networkStatus', function(response) {
//     try {
//         if (response.status == 1) {
//             $('#chat-user-' + response.user_id).find('.status-circle').css('background', 'green');
//         } else {
//             $('#chat-user-' + response.user_id).find('.status-circle').css('background', 'red');
//         }
//     } catch (error) {
//         console.error(error);
//     }
// });


socket.on('networkStatus', function(response) {
    try {
        if (response.status == 1) {
            
            $('#chat-user-' + response.user_id).find('.status-circle').removeClass('di__user_status');
            $('#chat-user-' + response.user_id).find('.status-circle').addClass('di__user_status di__user_status--live');
        } else {
            $('#chat-user-' + response.user_id).find('.status-circle').removeClass('di__user_status di__user_status--live');
            $('#chat-user-' + response.user_id).find('.status-circle').addClass('di__user_status');
        }
    } catch (error) {
        console.error(error);
    }
});

$(document).ready(function () {
    $('.leave-group-btn').remove();
    $('.delete-group-btn').remove();
    chat_user = getUserById($('#contact-list').find('.active').data('user'));
    $('#chat_user_name').html('');
    console.log(chat_user);

        if (chat_user) {
            $('#chat_user_name').html(chat_user.name);
            $('#user_type').html(chat_user.user_type);
            $('#chat_user_profile').attr('src', chat_user.profile_image);
            $('.message_count').html(chat_user.message_count);                        
            page = 1;
            on_top = false;
            getUserChat(chat_user.id, 1, false, true);
        }
        else {
            $('ui#contact-list li:first-child').click();
        }
});

$(document).on('keyup', '#message', function (e) {
    e.preventDefault();
    if (e.keyCode == 13 && !e.shiftKey) {
        if (!$(this).val().includes('@')) {
            $('.send_btn').trigger('click');
        }
    }
});


$(document).on('keyup', '#message', function (e) {
    var group_chat_tag = $('ui#contact-list li.active').hasClass('chat-group');
    if (group_chat_tag) {
    if (e.key == '@') {
        var messge = $('#message').val();
        $("#message").autocomplete({
            source: function( request, response ) {
                // Fetch data
                $.ajax({
                  url: search_user_route,
                  type: 'post',
                  dataType: "json",
                  data: {
                        _token: csrf_token,
                        group_id: chat_group.id,
                        user_id: from_user.id,
                        search: request.term.substring(
                            request.term.lastIndexOf('@') + 1).toLowerCase().trim()
                    },
                    success: function( data ) {
                        // console.log(data);
                        var resp = $.map(data,function(obj){
                            return obj.name;
                       });
                        response( resp );
                    }
                });
                // getGroupById(chat_group.id, function(chat_grp) {
                //     this_grop = chat_grp;
                //     var grp_mem_ids = [];
                //     var data = [];
                //     this_grop.groupmember.forEach(ele => {
                //         if (ele.user_id != from_user.id) {
                //             grp_mem_ids.push(ele.user_id);
                //         }
                //     });
                //     var user_filter = all_users;
                //     user_filter.forEach(element => {
                //         if (grp_mem_ids.includes(element.id)) {
                //             data.push(element);
                //         }
                //     });
                //     var resp = $.map(data,function(obj){
                //         return obj.name;
                //     });
                //     response( resp );
                // });
            },
            select: function (event, ui) {
                event.stopPropagation();
                $('#message').val(messge + ui.item.lable); // display the selected text
                $('#message').val(messge + ui.item.value); // save selected id to input
                return false;
            }
        });
    } else {
        $("#message").attr("autocomplete", "off");
    }
    }
});

$(document).on('click', '.chat-user', function (e) {
    e.preventDefault();
    chat_group = '';
    $('.add_member').remove();
    $('.leave-group-btn').remove();
    $('.delete-group-btn').remove();
    chat_user = getUserById($(this).attr('data-user'));
    $(this).closest('li').addClass('active');
    $('.chat-user').removeClass('active');
    $(this).addClass('active');
    $('.chat-group').removeClass('active');
    $('#chat_user_name').html('');
    if (chat_user) {
        $('#chat_user_name').html(chat_user.name);
        // $('#chat_user_company_name').html(chat_user.company_name);
        $('#user_type').html(chat_user.user_type);
        console.log(chat_user.profile_url);
        $('#chat_user_profile').attr('src', chat_user.profile_url);
        page = 1;
        on_top = false;
        getUserChat(chat_user.id, 1, false, true);
    }
    // console.log('user', chat_user);
});

let group_id = '';
$(document).on('click', '.chat-group', function (e) {
    var this_grp = this;
    chat_user = '';
    e.preventDefault();
    group_id = $(this).attr('data-group');
    chat_group = getGrpById(group_id);
    getGroupById(group_id, function(chat_grp) {
    chat_group = chat_grp;
    var member_count = chat_group.groupmember.length;
    $('.chat-user').removeClass('active');
    $('.chat-group').removeClass('active');
    $('.add_member').remove();
    $('.leave-group-btn').remove();
    $('.delete-group-btn').remove();
    if (member_count == 1) {
        $('.delete-group').append('<a class="delete-group-btn" data-group_id="'+group_id+'"> <i class="fas fa-sign-out-alt"></i>Delete Group</a>');
    }
    $('.add_group_user_btn').append('<a href="javascript:void(0);" class="add_member" id="add_member'+group_id+'" data-member_cnt="'+member_count+'" data-group_id="'+group_id+'">'+member_count+' participants</a>');
    $('.leave-group-user').append('<a class="leave-group-btn" data-group_id="'+group_id+'"><i class="fas fa-sign-out-alt"></i>Leave Group</a>');
    $(this_grp).addClass('active');
    $('#chat_user_name').html('');
    $('#chat_user_company_name').html('');
    $("#user_type").html('');
    $('#chat_user_profile').attr('src','');
    if(chat_group) {
        $('#chat_user_name').html(chat_group.group_name);
        $('#chat_user_company_name').html(chat_group.company_name);
        if(chat_group.profile_url) {
            $('#chat_user_profile').attr('src', chat_group.profile_url);
        } else {
            $('#chat_user_profile').attr('src','/images/icon/user_img.png');
        }
        page = 1;
        on_top = false;
        getGroupChat(chat_group.id, 1, false, true); 
    }
    });
});

socket.on('message', function(msg) {
    // decodeString(msg.message, function(decode_message) {
    console.log(msg);
    if (msg.group_id == undefined || msg.group_id == '' || msg.group_id == null) {
        if (msg.documents != 'undefined' || msg.documents.length > 0) {
            $.each(msg.documents, function (index, doc) {
                let rowDocRes = [];
                var lstDocRows = new Array();
                rowDocRes.message = doc.document_url;
                rowDocRes.document_name = doc.document;
                rowDocRes.time = moment().format('HH:mm');
                rowDocRes.profile_photo_path = msg.from_user_profile_url;
                lstDocRows.push(rowDocRes);
                if (msg.from == from_user.id) {
                    if (msg.from == chat_user.id) {
                        if (chat_user.last_message == '' || chat_user.last_message == null) {
                            var now_date_ur = moment().format('DD-MMM-YYYY');
                            var pre_dt_ur = $(".lst_ur_msg_dt").text();
                            if (pre_dt_ur != now_date_ur) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                            }
                        } else {
                            var lastMsgDt = moment.utc(chat_user.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                            var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                            var now_date_ur = moment().format('DD-MMM-YYYY');
                            if (lastMsg_date != now_date_ur) {
                                var pre_dt_ur = $(".lst_ur_msg_dt").text();
                                if (pre_dt_ur != now_date_ur) {
                                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                                }
                            }
                        }
                        $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                        if (checkImage(rowDocRes.message)) {
                            appendUserchat(lstRows,'self','img','append');
                        } else if (checkVideo(rowDocRes.message)) {
                            appendUserchat(lstRows,'self','video','append');
                        } else if (checkAudio(rowDocRes.message)) {
                            appendUserchat(lstRows,'self','audio','append');
                        } else {
                            appendUserchat(lstRows,'self','doc','append');
                        }
                    } else {
                        var cont = $('#user_msg_' + msg.from).html();
                        if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                            cont = 0;
                        }
                        cont = parseInt(cont) + 1;
                        $('#user_msg_' + msg.from).html(cont);
                    }
                } else if (msg.from == chat_user.id) {
                    $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                    if (chat_user.last_message == '' || chat_user.last_message == null) {
                        var now_date_ur = moment().format('DD-MMM-YYYY');
                        var pre_dt_ur = $(".lst_ur_msg_dt").text();
                        if (pre_dt_ur != now_date_ur) {
                            $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                        }
                    } else {
                        var lastMsgDt = moment.utc(chat_user.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                        var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                        var now_date_ur = moment().format('DD-MMM-YYYY');
                        if (lastMsg_date != now_date_ur) {
                            var pre_dt_ur = $(".lst_ur_msg_dt").text();
                            if (pre_dt_ur != now_date_ur) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                            }
                        }
                    }
                                       
                    if (checkImage(rowDocRes.message)) {
                        //appendUserchat(lstDocRows,'user','img','append');
                        // console.log('for test =',rowDocRes.message);
                        console.log('This is calling for img to show on user side real time chat');
                        
                        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
                        Message +='<div class="d-flex align-items-start gap-3">';
                        Message +='<div class="contact-avatar"><img src="'+rowDocRes.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
                        Message += '<div class="msg_container"><a href="'+rowDocRes.message+'" target="_blank"><p class="mb-0"><img class="chat_image" width="200px;" height="200px;" src="'+rowDocRes.message+'"></img></p></a></div>';
                        Message += '</div>';
                        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+rowDocRes.time+'</span>';
                        Message += '</div></div></li>';
                        $(".msg_card_body").append(Message);
        
                    } else if (checkVideo(rowDocRes.message)) {
                        appendUserchat(lstDocRows,'user','video','append');
                    } else if (checkAudio(rowDocRes.message)) {
                        appendUserchat(lstDocRows,'user','audio','append');
                    } else {
                        //appendUserchat(lstDocRows,'user','doc','append');
                        
                        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
                        Message +='<div class="d-flex align-items-start gap-3">';
                        Message +='<div class="contact-avatar"><img src="'+rowDocRes.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
                        Message += '<div class="msg_container"><a href="'+rowDocRes.message+'" target="_blank"><p class="mb-0">'+rowDocRes.message+'</p></a></div>';
                        Message += '</div>';
                        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+rowDocRes.time+'</span>';
                        Message += '</div></div></li>';
                        $(".msg_card_body").append(Message);
                        
                        console.log('latest message here');
                        
                    }
                    /// Need to update here
                    
                } else {
                    var cont = $('#user_msg_' + msg.from).html();
                    if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                        cont = 0;
                    }
                    cont = parseInt(cont) + 1;
                    $('#user_msg_' + msg.from).html(cont);
                }
                $('#chat-user-'+msg.from+'').find('p.user_last_msg').text(doc.document);
            });
            var first_user = $('#contact-list').find('#chat-user-'+msg.from+'');
            first_user.remove();
            
            $('#contact-list').prepend(first_user);
        }
        if (msg.message != '') {
            decodeString(msg.message, function(decode_message) {
            if (msg.from == from_user.id) {
                console.log('encoded message', msg.message);
                decode_message = msg.message;
                let rowRes = [];
                var lstRows = new Array();
                rowRes.message = msg.message;
                rowRes.profile_photo_path = msg.from_user_profile_url;
                rowRes.time = moment().format('HH:mm');
                lstRows.push(rowRes);
                if (msg.from == chat_user.id) {
                    $('#chat-user-'+chat_user.id+'').find('p.user_last_msg').text(decode_message);
                    if (chat_user.last_message == '' || chat_user.last_message == null) {
                        var now_date_ur = moment().format('DD-MMM-YYYY');
                        var pre_dt_ur = $(".lst_ur_msg_dt").text();
                        if (pre_dt_ur != now_date_ur) {
                            $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                        }
                    } else {
                        var lastMsgDt = moment.utc(chat_user.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                        var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                        var now_date_ur = moment().format('DD-MMM-YYYY');
                        if (lastMsg_date != now_date_ur) {
                            var pre_dt_ur = $(".lst_ur_msg_dt").text();
                            if (pre_dt_ur != now_date_ur) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                            }
                        }
                    }
                    $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                    // $(".msg_card_body").append($.tmpl($("#jsSelfTemplate").html(), lstRows));
                    appendReceivedMessageForOtherUser(lstRows);
                    console.log('what is this');
                } else {
                    $('#chat-user-'+msg.from+'').find('p.user_last_msg').text(decode_message);
                    let cont = $('#user_msg_' + msg.from).html();
                    if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                        cont = 0;
                    }
                    cont = parseInt(cont) + 1;
                    $('#user_msg_' + msg.from).html(cont);
                }
            } else if (msg.from == chat_user.id) {
                let rowRes = [];
                var lstRows = new Array();
                rowRes.message = msg.message;
                if (from_user.id == msg.from) {
                    rowRes.profile_photo_path = msg.from_user_profile_url;
                } else {
                    rowRes.profile_photo_path = msg.to_user_profile_url;
                }
                rowRes.time = moment().format('HH:mm');
                lstRows.push(rowRes);
                if (chat_user.last_message == '' || chat_user.last_message == null) {
                    var now_date_ur = moment().format('DD-MMM-YYYY');
                    var pre_dt_ur = $(".lst_ur_msg_dt").text();
                    if (pre_dt_ur != now_date_ur) {
                        $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                    }
                } else {
                    var lastMsgDt = moment.utc(chat_user.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                    var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                    var now_date_ur = moment().format('DD-MMM-YYYY');
                    if (lastMsg_date != now_date_ur) {
                        var pre_dt_ur = $(".lst_ur_msg_dt").text();
                        if (pre_dt_ur != now_date_ur) {
                            $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                        }
                    }
                }
                $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                
                //appendUserchat(lstRows,'user',''); // arvind
                
                
                // <li class="clearfix">
                //     <div class="message user-message my-message">
                //         <div class="d-flex justify-content-start mb-2 chat_box position-relative">
                //             <div class="d-flex align-items-start gap-3">
                //                 <div class="contact-avatar">
                //                     <img src="undefined" alt="avatar" width="45" height="45" class="rounded-circle bg-primary">
                //                 </div>
                //                 <div class="msg_container">
                //                     <p class="mb-0">saassssssssssssssssssssss</p>
                //                 </div>
                //             </div>
                //             <span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">11:35</span>
                //         </div>
                //     </div>
                // </li>
                
                
                
                
                
                 /// arvind here
                
                // appendReceivedMessageForOtherUser(msg.message,msg.time_diff,msg.from_user_profile_url,'');
                appendReceivedMessageForOtherUser(lstRows);
        
            } else {
                let cont = $('#user_msg_' + msg.from).html();
                if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                    cont = 0;
                }
                cont = parseInt(cont) + 1;
                $('#user_msg_' + msg.from).html(cont);
            }
            $('#chat-user-'+msg.from+'').find('p.user_last_msg').text(decode_message);
            var first_user = $('#contact-list').find('#chat-user-'+msg.from+'');
            first_user.remove();
            $('#contact-list').prepend(first_user);
            });
        }
        
        $('.chat-history-main').stop().animate({
            scrollTop: $('.chat-history-main')[0].scrollHeight
        }, 1500);
        
        // $('#msg_card_body').stop().animate({
        //     scrollTop: $('#msg_card_body')[0].scrollHeight
        // }, 1500);
    } else {
        // console.log(chat_group);
        if (msg.documents != 'undefined' || msg.documents.length > 0) {
            $.each(msg.documents, function (index, doc) {
                let rowDocRes = [];
                var lstDocRows = new Array();
                rowDocRes.message = doc.document_url;
                rowDocRes.document_name = doc.document;
                rowDocRes.time = moment().format('HH:mm');
                rowDocRes.profile_photo_path = msg.from_user_profile_url;
                lstDocRows.push(rowDocRes);
                if (msg.from == from_user.id) {
                    if (msg.group_id == chat_group.id) {
                        $('#chat-group-'+chat_group.id+'').find('p.group_last_msg').text('You: '+ doc.document);
                        if (chat_group.last_message != '' || chat_group.last_message != null) {
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            var pre_dt_gp = $(".lst_gp_msg_dt").text();
                            if (pre_dt_gp != now_date_gp) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                            }
                        } else {
                            var lastMsgDt = moment.utc(chat_group.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                            var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            if (lastMsg_date != now_date_gp) {
                                var pre_dt_gp = $(".lst_gp_msg_dt").text();
                                if (pre_dt_gp != now_date_gp) {
                                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                                }
                            }
                        }
                        $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                                          
                        console.log('its not calling',lstDocRows);
                        if (checkImage(rowDocRes.message)) {
                            appendUserchat(lstDocRows,'self','img','append','grp');
                        } else if (checkVideo(rowDocRes.message)) {
                            appendUserchat(lstDocRows,'self','video','append','grp');
                        } else if (checkAudio(rowDocRes.message)) {
                            appendUserchat(lstDocRows,'self','audio','append','grp');
                        } else {
                            appendUserchat(lstDocRows,'self','doc','append','grp');
                        }
                        
                        
                    } else {
                        $('#chat-group-'+msg.group_id+'').find('p.group_last_msg').text('You: '+ doc.document);
                        var cont = $('#group_msg_' + msg.group_id).html();
                        if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                            cont = 0;
                        }
                        cont = parseInt(cont) + 1;
                        $('#group_msg_' + msg.group_id).html(cont);
                    }
                } else if (chat_group != undefined) {
                    if (msg.group_id == chat_group.id) {
                        $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                        if (chat_group.last_message != '' || chat_group.last_message != null) {
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            var pre_dt_gp = $(".lst_gp_msg_dt").text();
                            if (pre_dt_gp != now_date_gp) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                            }
                        } else {
                            var lastMsgDt = moment.utc(chat_group.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                            var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            if (lastMsg_date != now_date_gp) {
                                var pre_dt_gp = $(".lst_gp_msg_dt").text();
                                if (pre_dt_gp != now_date_gp) {
                                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                                }
                            }
                        }
                        console.log('its calling',lstDocRows);   //arvind here
                        
                        if (checkImage(rowDocRes.message)) {
                            appendReceivedMessageForOtherUser(lstDocRows,'img');
                            // appendUserchat(lstDocRows,'user','img','append',);
                        } else if (checkVideo(rowDocRes.message)) {
                            appendReceivedMessageForOtherUser(lstDocRows,'video');
                            // appendUserchat(lstDocRows,'user','video','append',);
                        } else if (checkAudio(rowDocRes.message)) {
                            appendReceivedMessageForOtherUser(lstDocRows,'audio');
                            // appendUserchat(lstDocRows,'user','audio','append',);
                        } else {
                            appendReceivedMessageForOtherUser(lstDocRows,'doc');
                            // appendUserchat(lstDocRows,'user','doc','append',);
                        }
                        
                    } else {
                        var cont = $('#group_msg_' + msg.group_id).html();
                        if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                            cont = 0;
                        }
                        cont = parseInt(cont) + 1;
                        $('#group_msg_' + msg.group_id).html(cont);
                    }
                } else {
                    var cont = $('#group_msg_' + msg.group_id).html();
                    if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                        cont = 0;
                    }
                    cont = parseInt(cont) + 1;
                    $('#group_msg_' + msg.group_id).html(cont);
                }
                var last_msg_user = getUserById(msg.from);
                $('#chat-group-'+msg.group_id+'').find('p.group_last_msg').text(last_msg_user.name +': '+ doc.document);
            });
            var first_user = $('#contact-list').find('#chat-group-'+msg.group_id+'');
            first_user.remove();
            $('#contact-list').prepend(first_user);
        }
        if (msg.message != '') {
            decodeString(msg.message, function(decode_message) {
            if (msg.from == from_user.id) {
                let rowRes = [];
                var lstRows = new Array();
                rowRes.message = decode_message;
                rowRes.profile_photo_path = msg.from_user_profile_url;
                rowRes.time = moment().format('HH:mm');
                lstRows.push(rowRes);
                if (msg.group_id == chat_group.id) {
                    $('#chat-group-'+chat_group.id+'').find('p.group_last_msg').text('You: '+ decode_message);
                    if (msg.message_type == 1) {
                        $(".msg_card_body").append('<div class="d-flex justify-content-center"><p>'+decode_message+'</p></div>');
                    } else {
                        if (chat_group.last_message != '' || chat_group.last_message != null) {
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            var pre_dt_gp = $(".lst_gp_msg_dt").text();
                            if (pre_dt_gp != now_date_gp) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                            }
                        } else {
                            var lastMsgDt = moment.utc(chat_group.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                            var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            if (lastMsg_date != now_date_gp) {
                                var pre_dt_gp = $(".lst_gp_msg_dt").text();
                                if (pre_dt_gp != now_date_gp) {
                                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                                }
                            }
                        }
                        $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                        // $(".msg_card_body").append($.tmpl($("#jsSelfTemplate").html(), lstRows));
                        appendReceivedMessageForOtherUser(lstRows);
                    }
                } else {
                    $('#chat-group-'+msg.group_id+'').find('p.group_last_msg').text('You: '+ decode_message);
                    var cont = $('#group_msg_' + msg.group_id).html();
                    if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                        cont = 0;
                    }
                    cont = parseInt(cont) + 1;
                    $('#group_msg_' + msg.group_id).html(cont);
                }
            } else if (chat_group != undefined) {
                if (msg.group_id == chat_group.id) {
                    if (msg.message_type == 1) {
                        $(".msg_card_body").append('<div class="d-flex justify-content-center"><p>'+decode_message+'</p></div>');
                    } else {
                        let rowRes = [];
                        var lstRows = new Array();
                        rowRes.message = decode_message;
                        if (from_user.id == msg.from) {
                            rowRes.profile_photo_path = msg.from_user_profile_url;
                        } else {
                            rowRes.profile_photo_path = msg.to_user_profile_url;
                        }
                        rowRes.time = moment().format('HH:mm');
                        lstRows.push(rowRes);
                        if (chat_group.last_message != '' || chat_group.last_message != null) {
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            var pre_dt_gp = $(".lst_gp_msg_dt").text();
                            if (pre_dt_gp != now_date_gp) {
                                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                            }
                        } else {
                            var lastMsgDt = moment.utc(chat_group.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                            var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                            var now_date_gp = moment().format('DD-MMM-YYYY');
                            if (lastMsg_date != now_date_gp) {
                                var pre_dt_gp = $(".lst_gp_msg_dt").text();
                                if (pre_dt_gp != now_date_gp) {
                                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                                }
                            }
                        }
                        $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
                        // appendUserchat(lstRows,'user','','append','grp');
                        appendReceivedMessageForOtherUser(lstRows);
                    }
                } else {
                    var cont = $('#group_msg_' + msg.group_id).html();
                    if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                        cont = 0;
                    }
                    cont = parseInt(cont) + 1;
                    $('#group_msg_' + msg.group_id).html(cont);
                }
            } else {
                var cont = $('#group_msg_' + msg.group_id).html();
                if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
                    cont = 0;
                }
                cont = parseInt(cont) + 1;
                $('#group_msg_' + msg.group_id).html(cont);
            }
            var last_msg_user = getUserById(msg.from);
            $('#chat-group-'+msg.group_id+'').find('p.group_last_msg').text(last_msg_user.name +': '+ decode_message);
            var first_user = $('#contact-list').find('#chat-group-'+msg.group_id+'');
            first_user.remove();
            $('#contact-list').prepend(first_user);
            });
        }
        $('#msg_card_body').stop().animate({
            scrollTop: $('#msg_card_body')[0].scrollHeight
        }, 1500);
    }
// });
});

$(document).on('keyup', '#search', function (e) {
    e.preventDefault();
    let term = $(this).val();
    $.each(users, function (index, value) {
        if (value.name.toLowerCase().trim().includes(term.toLowerCase().trim())) {
            $('#chat-user-' + value.id).removeClass('d-none');
        } else {
            $('#chat-user-' + value.id).addClass('d-none');
        }
    });
    $.each(groups, function (index, value) {
        if (value.group_name.toLowerCase().trim().includes(term.toLowerCase().trim())) {
            $('#chat-group-' + value.id).removeClass('d-none');
        } else {
            $('#chat-group-' + value.id).addClass('d-none');
        }
    });
    if ($('.chat-user').not('.d-none').length == 0) {
        $('.no_records_found').removeClass('d-none');
    } else if ($('.chat-group').not('.d-none').length == 0) {
        $('.no_records_found').removeClass('d-none');
    } else {
        $('.no_records_found').addClass('d-none');
    }
});

$(document).on('click', '#search', function (e) {
    e.preventDefault();
    let term = $(this).val();
    $.each(users, function (index, value) {
        if (value.name.toLowerCase().trim().includes(term.toLowerCase().trim())) {
            $('#chat-user-' + value.id).removeClass('d-none');
        } else {
            $('#chat-user-' + value.id).addClass('d-none');
        }
    });
    $.each(groups, function (index, value) {
        if (value.group_name.toLowerCase().trim().includes(term.toLowerCase().trim())) {
            $('#chat-group-' + value.id).removeClass('d-none');
        } else {
            $('#chat-group-' + value.id).addClass('d-none');
        }
    });
    if ($('.chat-user').not('.d-none').length == 0) {
        $('.no_records_found').removeClass('d-none');
    } else if ($('.chat-group').not('.d-none').length == 0) {
        $('.no_records_found').removeClass('d-none');
    } else {
        $('.no_records_found').addClass('d-none');
    }
});


$(document).on('keyup', '#search_user', function (e) {
    e.preventDefault();
    let term = $(this).val();
    $.each(users, function (index, value) {
        if (value.name.toLowerCase().trim().includes(term.toLowerCase().trim())) {
            $('li#list-user-' + value.id).removeClass('d-none');
        } else {
            $('li#list-user-' + value.id).addClass('d-none');
        }
    });
});

$(document).on('click','.group_btn', function(e) {
    e.preventDefault();
    $("#group_modal").modal('show');
});

$('#group_modal').on('hidden.bs.modal', function () {
    $('.list-user').removeClass('d-none');
    $(this).find('form').trigger('reset');
})

$(document).on('click','#create_new_group', function(e) {
    e.preventDefault();
    var val = [];
    let token = $(this).closest('form').find('input[name="_token"]').val();
    let group_name = $(this).closest('form').find("#group_name").val();
    if (group_name == undefined || group_name == null || group_name == '') {
        //toastr.error('The Group Name Field Is Required.');
        alert('The Group Name Field Is Required.');
    }
    let user_id = $(this).closest('form').find("#user_id").val();
    $(':checkbox:checked').each(function(i){
        val[i] = $(this).val();
    });
    if (val == undefined || val == null || val == '') {
        // toastr.error('Please Select Atleast One Member.');
        alert('Please Select Atleast One Member.');
    }
    let url = create_group_chat;
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            _token : token,
            group_name : group_name,
            val : val,
            user_id : user_id
        },
        success: function (response) {
            $("#group_modal").modal('hide');
            $('.chat-user').removeClass('active');
            $('.chat-group').removeClass('active');
            var group_html = '<li class="d-flex justify-content-between chat-group active" id="chat-group-'+response.data.group_data.id+'" data-group="'+response.data.group_data.id+'">'
                                +'<div class="d-flex gap-2 gap-lg-3 align-items-center">'
                                +'<div class="contact-avatar group_profile">'
                                    +'<div class="img-wrapper img_cont">'
                                        +'<img src="'+response.data.group_data.profile_url+'"  class="rounded-circle bg-primary" width="39" height="39">'
                                        +'<div class="group-icon"><i class="fas fa-users" style="color:grey"></i></div>'
                                    +'</div>'
                                +'</div>'  
                                +'<div class="contacts__about">'
                                    +'<div class="group_info">'
                                        +'<p class="mb-0 fw-smedium">'+response.data.group_data.group_name+'</p>'
                                    +'</div>'
                                    +'<div class="contact__msg">'
                                        +'<p class="group_last_msg"></p>'                                              
                                    +'</div>'        
                                +'</div>'
                                    +'<div class="msg_count" id="group_msg_'+response.data.group_data.id+'"></div>'
                                +'</div>'
                            +'</li>';
            $('#contact-list').prepend(group_html);
            $('#chat-group-'+response.data.group_data.id+'').click();
            var uuid = new Date().getTime() + from_user.id;
            var message = 'This group is created on ' + new Date().toDateString() + ' by ' + from_user.name;
            var _message = message.replace(/\\/g, "\\\\");
            
                socket.emit('createGroup', { group_id: response.data.group_data.id, group_name: response.data.group_data.group_name });
                socket.emit('vendorGroupMessage', { message: _message, message_type:1, from: from_user, send_group: response.data.group_data, uuid: uuid });
            
        },
        error: function (error) {
            console.log(error);
        }
    });
});

$(document).on('click','.add_member',function () {
    var group_id = $(this).data('group_id');
    var is_modal_exist = document.getElementById('add_group_member_'+group_id+'');
    if (!(is_modal_exist == null || is_modal_exist == undefined)) {
        is_modal_exist.remove();
    }
        var this_grop = groups.filter(function (key, value) {
            return key.id == group_id;
        })[0];
        getGroupById(group_id, function(chat_grp) {
        this_grop = chat_grp;
        var grp_mem_list_html = '';
        var grp_mem_list_html_1 = '';
        var grp_mem_list_html_2 = '';
        var grp_mem_ids = [];
        this_grop.groupmember.forEach(ele => {
            grp_mem_ids.push(ele.user_id);
        });
        var user_filter = all_users;
        user_filter.forEach(element => {
            var input_btn = '';
            var img_url = '';
            if (element.profile_url == '' || element.profile_url == null) {
                img_url = default_img_url;
            } else {
                img_url = element.profile_url;
            }
            if (this_grop.user_id == from_user.id) {
                if (grp_mem_ids.includes(element.id)) {
                    input_btn = '<input type="button" class="btn btn-danger user_remove" name="user_checkbox" data-id="'+element.id+'" value="Remove" id="user-'+element.id+'">';
                } else {
                    input_btn = '<input type="button" class="btn btn-primary user_add" name="user_checkbox" data-id="'+element.id+'" value="Add" id="user-'+element.id+'">';
                }
            }
            if (this_grop.user_id != from_user.id) {
                if (grp_mem_ids.includes(element.id)) {
                    grp_mem_list_html_2 += '<li class="list-user" id="list-user-'+element.id+'" data-user="'+element.id+'">'
                                    +'<div class="d-flex bd-highlight" style="justify-content: space-between">'
                                        +'<div class="user_profile">'
                                            +'<div class="img_cont">'
                                                +'<img src="'+img_url+'" class="rounded-circle user_img">'
                                            +'</div>'
                                            +'<div class="user_info">'
                                                +'<span>'+element.name+'</span>'
                                            +'</div>'
                                        +'</div>'
                                        +input_btn
                                    +'</div>'
                                +'</li>';
                }
            } else {
                grp_mem_list_html_1 += '<li class="list-user" id="list-user-'+element.id+'" data-user="'+element.id+'">'
                                +'<div class="d-flex bd-highlight" style="justify-content: space-between">'
                                    +'<div class="user_profile">'
                                        +'<div class="img_cont">'
                                            +'<img src="'+img_url+'" class="rounded-circle user_img">'
                                        +'</div>'
                                        +'<div class="user_info">'
                                            +'<span>'+element.name+'</span>'
                                        +'</div>'
                                    +'</div>'
                                    +input_btn
                                +'</div>'
                            +'</li>';
            }
        });
        if (this_grop.user_id != from_user.id) {
            grp_mem_list_html = grp_mem_list_html_2;
        } else {
            grp_mem_list_html = grp_mem_list_html_1;
        }
        var is_readonly = '';
        var input_image = '';
        var save_btn = '';
        if (this_grop.user_id != from_user.id) {
            is_readonly = 'readonly';
        } else {
            input_image = '<input type="file" name="group_profile" id="group_profile" class="form-control">'
        }
        if (this_grop.user_id == from_user.id) {
            save_btn = '<input type="button" class="btn btn-success group_name_save" name="save" value="Save">';
        }
        var grp_mem_modal = '<div id="add_group_member_'+this_grop.id+'" class="modal fade add_group_member" style="display: block; padding-right: 17px;" aria-modal="true" role="dialog">'
                                +'<div class="modal-dialog">'
                                    +'<div class="modal-content">'
                                        +'<div class="modal-header">'
                                            +'<h4 class="modal-title">Group Participants</h4>'
                                            +'<button type="button" class="close close_grp_mem_modal" data-dismiss="modal">×</button>'
                                        +'</div>'
                                        +'<div class="modal-body">'
                                            +'<form name="join_grp" id="join_grp" method="post">'
                                                +'<input type="hidden" name="_token" value="'+csrf_token+'">'
                                                +'<p class="label-control">Group Name</p>'
                                                +'<input type="hidden" name="user_id" id="user_id" value="'+from_user.id+'">'
                                                +'<input type="hidden" name="group_id" id="group_id" value="'+this_grop.id+'">'
                                                +'<input type="text" name="group_name_join" id="group_name_join" placeholder="Group Name" value="'+this_grop.group_name+'" class="form-control" required="" '+is_readonly+'>'
                                                +'<br>'
                                                +input_image
                                                +'<br>'
                                                +save_btn
                                                +'<br>'
                                                +'<h2>Contacts</h2>'
                                                +'<input type="text" placeholder="Search..." name="" class="form-control" id="search_user">'
                                                +'<ui class="contacts" id="contact-list">'
                                                +grp_mem_list_html
                                                +'</ui>'
                                            +'</form>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>';
        $('.po__chatbox--section').append(grp_mem_modal);
    // }
    $('#add_group_member_'+group_id+'').modal('show');
});
});

$(document).on('click','.close_grp_mem_modal', function(e) {
    $('.add_group_member').modal('hide');
});

$(document).on('click','.delete-group-btn', function() {
    if (confirm("Are you sure want to leave this group")) {
        $group_id = $(this).attr('data-group_id');
        $.ajax({
            type: 'POST',
            url: delete_grp_url,
            data: {
                _token : csrf_token,
                group_id : group_id
            },
            success: function (response) {
                // toastr.success(response.message);
                alert(response.message);
                var group_to_remove = $('#contact-list').find('#chat-group-'+response.data.group_id+'');
                group_to_remove.remove();
                socket.emit('changeGroupMember', { group_id: group_id, group_name: '', member_id: from_user.id, mode: 'group_deleted' });
                $('ui#contact-list li:first-child').click();
            }
        });
    }
});

$(document).on('click','.leave-group-btn', function() {
    if (confirm("Are you sure want to leave this group")) {
        var _this = this;
        var group_id = $(this).data('group_id');
        var url = leave_group_url;
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                _token : csrf_token,
                group_id : group_id
            },
            success: function (response) {
                var uuid = new Date().getTime() + response.data.user.id;
                var message = response.data.user.name+' leave this group';
                var _message = message.replace(/\\/g, "\\\\");
                // encodeString(_message, function(encode_message) {
                    socket.emit('vendorGroupMessage', { message: _message, message_type:1, from: response.data.user, send_group: chat_group, uuid: uuid });
                    socket.emit('changeGroupMember', { group_id: response.data.group_id, group_name: '', member_id: response.data.user.id, mode: 'member_leave'});
                // });
                var group_to_remove = $('#contact-list').find('#chat-group-'+response.data.group_id+'');
                group_to_remove.remove();
                $('ui#contact-list li:first-child').click();
            }
        });
    }
});



$(document).on('click','.user_add', function(e) {
    e.preventDefault();
    var user_this = this;
    var val = [];
    let token = $(this).closest('form').find('input[name="_token"]').val();
    let group_id = $(this).closest('form').find("#group_id").val();
    let user_id = $(this).data('id');
    let url = add_new_member;
    
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            _token : token,
            group_id : group_id,
            user_id : user_id
        },
        success: function (response) {
            var grp_me_ct = $('#add_member'+response.data.group_data[0].id+'').data('member_cnt');
            $('#add_member'+response.data.group_data[0].id+'').data('member_cnt', grp_me_ct + 1);
            $('#add_member'+response.data.group_data[0].id+'').text(grp_me_ct + 1 + ' participants');
            var added_user = getUserById(user_id);
            $(".msg_card_body").append('<div class="d-flex justify-content-center"><p>'+from_user.name+' added '+added_user.name+' to this group</p></div>');
            var uuid = new Date().getTime() + from_user.id;
            var message = from_user.name+' added '+added_user.name+' to this group';
            var _message = message.replace(/\\/g, "\\\\");
            // encodeString(_message, function(encode_message) {
                socket.emit('vendorGroupMessage', { message: _message, message_type:1, from: from_user, send_group: chat_group, uuid: uuid });
                socket.emit('changeGroupMember', { group_id: response.data.group_data[0].id, group_name: response.data.group_data[0].group_name, member_id: response.data.added_group_member, mode: 'member_added' });
            // });
            $('#chat-group-'+response.data.group_data[0].id+'').find('p.group_last_msg').text('You: '+ _message);
            $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
            $(".add_group_member").modal('hide');
            $('.delete-group-btn').remove();
            $(user_this).addClass('user_remove');
            $(".user_remove").removeClass('user_add');
            $(".user_remove").addClass('btn-danger');
            $(".user_remove").removeClass('btn-primary');
            $(".user_remove").val('');
            $(".user_remove").val('Remove');
            var first_user = $('#contact-list').find('#chat-group-'+response.data.group_data[0].id+'');
            first_user.remove();
            $('#contact-list').prepend(first_user);
        }
    });
});

$(document).on('click','.group_name_save', function(e) {
    e.preventDefault();
    let token = $(this).closest('form').find('input[name="_token"]').val();
    let group_id = $(this).closest('form').find("#group_id").val();
    let user_id = $(this).data('id');
    let group_nam = $(this).closest('form').find("#group_name_join").val();
    if (group_name == undefined || group_name == null || group_name == '') {
        // toastr.error('The Group Name Field Is Required.');
        alert('The Group Name Field Is Required.');
        return false;
    }
    let group_pro = $(this).closest('form').find('#group_profile');
    if (group_pro[0].files[0] != '' && group_pro[0].files[0] != null && group_pro[0].files[0] != undefined) {
        var extension = group_pro[0].files[0].name.substring(
            group_pro[0].files[0].name.lastIndexOf('.') + 1).toLowerCase();
        if (!(extension == "jpg" || extension == "png" || extension == "jpeg")) {
            // toastr.error('Extention not allowed. Only .jpg .jpeg .png file allowed');
            alert('Extention not allowed. Only .jpg .jpeg .png file allowed');
            return false;
        }
        if (group_pro[0].files[0].size > 2048000) {
            // toastr.error('File upload max size: 2 MB');
            alert('File upload max size: 2 MB');
            return false;
        }
    }

    var formData = new FormData();
    formData.append('_token', token);
    formData.append('group_id', group_id);
    formData.append('user_id', user_id);
    formData.append('group_name', group_nam);
    formData.append('group_profile', group_pro[0].files[0]);
    let url = update_group;

    $.ajax({
        type: 'POST',
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            $(".add_group_member").modal('hide');
            $('#chat_user_name').text(response.data.group_data.group_name);
            $('#chat_user_profile').attr('src', response.data.group_data.profile_url);
            $('#chat-group-'+response.data.group_data.id+'').find('div.img_cont img').attr('src', response.data.group_data.profile_url);
            $('#chat-group-'+response.data.group_data.id+'').find('div.group_info span').text(response.data.group_data.group_name);
            if (response.data.profile_changed == 1) {
                var uuid = new Date().getTime() + from_user.id;
                var message = from_user.name+' has changed group profile picture';
                var _message = message.replace(/\\/g, "\\\\");
                $(".msg_card_body").append('<div class="d-flex justify-content-center"><p>'+_message+'</p></div>');
                encodeString(_message, function(encode_message) {
                    socket.emit('vendorGroupMessage', { message: encode_message, message_type:1, from: from_user, send_group: chat_group, uuid: uuid });
                    socket.emit('changeGroupMember', { group_id: response.data.group_data.id, group_name: response.data.group_data.group_name, member_id: '', mode: 'group_name_changed', group_pro_url: response.data.group_data.profile_url});
                });
                $('#chat-group-'+response.data.group_data.id+'').find('p.group_last_msg').text('You: '+ _message);
                $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
            } else {
                var uuid = new Date().getTime() + from_user.id;
                var message = from_user.name+' has changed group name to '+response.data.group_data.group_name;
                var _message = message.replace(/\\/g, "\\\\");
                encodeString(_message, function(encode_message) {    
                    socket.emit('vendorGroupMessage', { message: encode_message, message_type:1, from: from_user, send_group: chat_group, uuid: uuid });
                    socket.emit('changeGroupMember', { group_id: response.data.group_data.id, group_name: response.data.group_data.group_name, member_id: '', mode: 'group_name_changed', group_pro_url: response.data.group_data.profile_url});
                });
            }
        }
    });
});


$(document).on('click','.user_remove', function(e) {
    e.preventDefault();
    var user_this = this;
    var val = [];
    let token = $(this).closest('form').find('input[name="_token"]').val();
    let group_id = $(this).closest('form').find("#group_id").val();
    let user_id = $(this).data('id');
    let url = remove_member;
    
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            _token : token,
            group_id : group_id,
            user_id : user_id
        },
        success: function (response) {
            var grp__me_ct = $('#add_member'+response.data.group_data[0].id+'').data('member_cnt');
            $('#add_member'+response.data.group_data[0].id+'').data('member_cnt', grp__me_ct - 1);
            $('#add_member'+response.data.group_data[0].id+'').text(grp__me_ct - 1 + ' participants');
            var added_user = getUserById(user_id);
            $(".msg_card_body").append('<div class="d-flex justify-content-center"><p>'+from_user.name+' has removed '+added_user.name+' from this group</p></div>');
            var uuid = new Date().getTime() + from_user.id;
            var message = from_user.name+' has removed '+added_user.name+' from this group';
            var _message = message.replace(/\\/g, "\\\\");
            encodeString(_message, function(encode_message) {
                socket.emit('vendorGroupMessage', { message: encode_message, message_type:1, from: from_user, send_group: chat_group, uuid: uuid });
                socket.emit('changeGroupMember', { group_id: response.data.group_data[0].id, group_name: response.data.group_data[0].group_name, member_id: response.data.removed_group_member, mode: 'member_removed' });
            });
            $('#chat-group-'+response.data.group_data[0].id+'').find('p.group_last_msg').text('You: '+ _message);
            $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
            $(".add_group_member").modal('hide');
            // var member_count = response.data.group_data[0].groupmember.length;
            // if (member_count == 1) {
            //     $('.delete-group').append('<a class="delete-group-btn" data-group_id="'+group_id+'"> <i class="fas fa-sign-out-alt"></i>Delete Group</a>');
            // }
            $(user_this).addClass('user_add');
            $(".user_add").removeClass('user_remove');
            $(".user_add").removeClass('btn-danger');
            $(".user_add").addClass('btn-primary');
            $(".user_add").val('');
            $(".user_add").val('Add');
            var first_user = $('#contact-list').find('#chat-group-'+response.data.group_data[0].id+'');
            first_user.remove();
            $('#contact-list').prepend(first_user);
        }
    });
});


$(document).on('click', '.send_btn', function (e) {
    e.preventDefault();
    let message = $('#message').val();
    if (message.length > 0 && message.trim() != '') {
        var uuid = new Date().getTime() + from_user.id;
        var _message = message.replace(/\\/g, "\\\\");
        
        
        
        if (chat_user == null || chat_user == '') {
            if (_message != '') {
                
                
                    socket.emit('vendorGroupMessage', { message: _message, message_type:0, from: from_user, send_group: chat_group, uuid: uuid });
                
            } else {
                socket.emit('vendorGroupMessage', { message: _message, message_type:0, from: from_user, send_group: chat_group, uuid: uuid });
            }
            $('#chat-group-'+chat_group.id+'').find('p.group_last_msg').text('You: '+ message);
        }
        else {
            if (_message != '') {
                console.log('chat_user = '+ chat_user.id);
                // encodeString(_message, function(encode_message) {
                //     socket.emit('vendorMessage', { message: encode_message, from: from_user, send: chat_user, uuid: uuid });
                // });
                socket.emit('vendorMessage', { message: _message, from: from_user, send: chat_user, uuid: uuid });
            } else {
                console.log('else: chat_user = '+ chat_user.id);
                socket.emit('vendorMessage', { message: _message, from: from_user, send: chat_user, uuid: uuid });
            }
            $('#chat-user-'+chat_user.id+'').find('p.user_last_msg').text(message);
        }
        
        let rowRes = [];
        var lstRows = new Array();
        rowRes.message = message;
        rowRes.profile_photo_path = from_user.profile_url;
        rowRes.time = moment().format('HH:mm');
        var chat_time = moment().format('HH:mm');
        lstRows.push(rowRes);
        
        if (chat_user == null || chat_user == '') {
            if (chat_group.last_message != '' || chat_group.last_message != null) {
                var now_date_gp = moment().format('DD-MMM-YYYY');
                var pre_dt_gp = $(".lst_gp_msg_dt").text();
                if (pre_dt_gp != now_date_gp) {
                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                }
            } else {
                var lastMsgDt = moment.utc(chat_group.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                var now_date_gp = moment().format('DD-MMM-YYYY');
                if (lastMsg_date != now_date_gp) {
                    var pre_dt_gp = $(".lst_gp_msg_dt").text();
                    if (pre_dt_gp != now_date_gp) {
                        $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+now_date_gp+'</p></div>');
                    }
                }
            }
        }
        else {
            if (chat_user.last_message == '' || chat_user.last_message == null) {
                var now_date_ur = moment().format('DD-MMM-YYYY');
                var pre_dt_ur = $(".lst_ur_msg_dt").text();
                if (pre_dt_ur != now_date_ur) {
                    $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                }
            } else {
                var lastMsgDt = moment.utc(chat_user.last_message.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                var lastMsg_date = moment(lastMsgDt).format('DD-MMM-YYYY');
                var now_date_ur = moment().format('DD-MMM-YYYY');
                if (lastMsg_date != now_date_ur) {
                    var pre_dt_ur = $(".lst_ur_msg_dt").text();
                    if (pre_dt_ur != now_date_ur) {
                        $(".msg_card_body").append('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+now_date_ur+'</p></div>');
                    }
                }
            }
        }
        
        $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);        
            
        var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
        selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><p class="mb-0">'+message+'</p><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_time+'</span></div></div></div></div></li>';
        $(".msg_card_body").append(selfMessage);
            
        $('#message').val('');
        // jsSelfTemplate
        if (chat_user == null || chat_user == '') {
            var first_user = $('#contact-list').find('#chat-group-'+chat_group.id+'');
        } else {
            var first_user = $('#contact-list').find('#chat-user-'+chat_user.id+'');
        }
        first_user.remove();      
        $('#contact-list').prepend(first_user);
    }
    
    $('.chat-history-main').stop().animate({
        scrollTop: $('.chat-history-main')[0].scrollHeight
    }, 1500);
});

function getUserById($user_id)
{
    return users.filter(function (key, value) {
        return key.id == $user_id;
    })[0];
}

function getGrpById($group_id) {
    groups.filter(function (key, value) {
        return key.id == $group_id;
    })[0];
}

function getGroupById($group_id, callback)
{
    var url = get_groups_route;
    $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
            groups = response.data.groups;
            callback(
                groups.filter(function (key, value) {
                    return key.id == $group_id;
                })[0]
            );
        }
    });
}

function encodeString(string, callback)
{
    var url = encode_string_url;
    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: {
            _token: csrf_token,
            string: string
        },
        success: function (response) {
            callback(response.data.string);
        }
    });
}

function decodeString(string, callback)
{
    var url = decode_string_url;
    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: {
            _token: csrf_token,
            string: string
        },
        success: function (response) {
            callback(response.data.string);
        }
    });
}

$('.chat-history-main').scroll(function(){
    if ($(this).scrollTop() == 0) {
        // console.log(chat_user.id);
        
        if (on_top == false) {
            if (processing == false) {
                page++;
                if (chat_user == null || chat_user == '') {
                    getGroupChat(chat_group.id, page, true, false);
                } else {
                    getUserChat(chat_user.id, page, true, false);
                }
            }
        }
    }
});

// $('.msg_card_body').scroll(function(){
//     if ($(this).scrollTop() == 0) {        
//         if (on_top == false) {
//             if (processing == false) {
//                 page++;
//                 if (chat_user == null || chat_user == '') {
//                     getGroupChat(chat_group.id, page, true, false);
//                 } else {
//                     getUserChat(chat_user.id, page, true, false);
//                 }
//             }
//         }
//     }
// });

function getUserChat(user_id, page = 1, from_scroll = false, user_change = true)
{
    $('#message').prop('disabled', true);
    $('#user_msg_' + user_id).html('');
    if (user_change) {
        $(".msg_card_body").html('');
    }
    let url = chat_user_route;
        url = url.replace(':id', user_id);
    $.ajax({
        url: url,
        method: 'GET',
        data: { page: page },
        beforeSend: function (response) {
            processing = true;
        },
        success: function (response) {
            
            
            // $('#chat_user_messages_count').html(response.total);
            if (typeof response.paginate_data != 'undefined') {
                var data = response.paginate_data;
            } else {
                var data = response.data;
            }
            var chat_date = '';
            
            

            $.each(data, function (key, value) {
                
                console.log('user profile path cheking = ',value);
                                
                var chat_time = value.display_time;
                var toDt = moment.utc(value.created_at, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                var chat_date_pre = chat_date;
                chat_date = moment(toDt).format('DD-MMM-YYYY');
                if (chat_date != chat_date_pre) {
                    if (chat_date_pre != '') {
                        if (chat_date_pre == moment().format('DD-MMM-YYYY')) {
                            $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p class="lst_ur_msg_dt">'+chat_date_pre+'</p></div>');
                        } else {
                            $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p>'+chat_date_pre+'</p></div>');
                        }
                    }
                }
                
                if (typeof value.documents !== 'undefined') {
                    $.each(value.documents, function (index, document) {
                        
                        let rowDocRes = [];
                        var lstDocRows = new Array();
                        rowDocRes.message = document.document_url;
                        rowDocRes.document_name = document.document;
                        rowDocRes.time = chat_time;
                        rowDocRes.profile_photo_path = value.vendor.profile_url;
                        //value.vendor.profile_url
                        lstDocRows.push(rowDocRes);
                        
// var selfMessage = '<li class="clearfix"><div class="message my-message"><div class="d-flex justify-content-end mb-2 chat_box">';
// selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+document.document_url+'" target="_blank"><p class="mb-0">'+document.document+'</p></a><span class="text-sm-10 mb-0">'+chat_time+'</span></div></div></div></div></li>';
// $(".msg_card_body").append(selfMessage);
                                
                                
                        if (value.from == from_user.id) {
                            if (checkImage(rowDocRes.message)) {
                                appendUserchat(rowDocRes,'self','img');
                            } else if (checkVideo(rowDocRes.message)) {
                                appendUserchat(rowDocRes,'self','video');
                            } else if (checkAudio(rowDocRes.message)) {
                                appendUserchat(rowDocRes,'self','audio');
                            } else {
                                appendUserchat(rowDocRes,'self','doc');        
                            }
                        } else {
                            
                            if (checkImage(rowDocRes.message)) {
                                appendUserchat(rowDocRes,'user','img');
                            } else if (checkVideo(rowDocRes.message)) {
                                appendUserchat(rowDocRes,'user','video');
                            } else if (checkAudio(rowDocRes.message)) {
                                appendUserchat(rowDocRes,'user','audio');
                            } else {
                                appendUserchat(rowDocRes,'user','doc');        
                            }
                            
                            // if (checkImage(rowDocRes.message)) {
                            //     $(".msg_card_body").prepend($.tmpl($("#jsUserImageTemplate").html(), lstDocRows));
                            // } else if (checkVideo(rowDocRes.message)) {
                            //     $(".msg_card_body").prepend($.tmpl($("#jsUserVideoTemplate").html(), lstDocRows));
                            // } else if (checkAudio(rowDocRes.message)) {
                            //     $(".msg_card_body").prepend($.tmpl($("#jsUserAudioTemplate").html(), lstDocRows));
                            // } else {
                            //     $(".msg_card_body").prepend($.tmpl($("#jsUserDocumentTemplate").html(), lstDocRows));
                            // }
                        }
                    });
                }
                
                // console.log(value);
                
                if (value.message != '') {
                    
                    let rowRes = [];
                    var lstRows = new Array();
                    rowRes.message = value.decrypted_msg;
                    rowRes.time = chat_time;
                    //console.log("Profile images=",value.vendor.profile_image_url);
                    rowRes.profile_photo_path = value.vendor.profile_image_url;
                    var profile_photo_path = value.vendor.profile_image_url;
                    lstRows.push(rowRes);
                    if (value.from == from_user.id) {
                        // $(".msg_card_body").prepend(lstRows);
                        // if(value.message!='undefined' || value.message!=null || value.message!=""){
                                                
                            var selfMessage = '<li class="clearfix">';
                                    selfMessage += '<div class="message reply-message other-message">';
                                    selfMessage += '<div class="d-flex justify-content-end mb-2 chat_box position-relative">';
                                    selfMessage += '<div class="d-flex align-items-start gap-3">';
                                        //selfMessage += '<div class="contact-avatar">';
                                            //selfMessage += '<img src="'+profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary">';
                                        //selfMessage += '</div>';
                                        selfMessage += '<div class="msg_container">';
                                            selfMessage += '<p class="mb-0">'+value.message+'</p>';
                                        selfMessage += '</div>';    
                                    selfMessage += '</div>';
                                    selfMessage += '<span class="di__chat_time text-tiny mb-0">'+value.display_time+'</span>';
                                selfMessage += '</div>';
                                selfMessage += '</div>';
                            selfMessage += '</li>';
                            $(".msg_card_body").prepend(selfMessage);
                            
                            //appendUserchat(rowDocRes,'self','');
                        // }
        
                    } else {
                        // $(".msg_card_body").prepend(lstRows);
                        
                        // if(value.message!='undefined' || value.message!=null || value.message!=""){
                            var OtherMessage = '<li class="clearfix">';
                            OtherMessage += '<div class="message user-message my-message">';
                            OtherMessage += '<div class="d-flex justify-content-start mb-2 chat_box position-relative">';
                            OtherMessage += '<div class="d-flex align-items-start gap-3">';
                            OtherMessage += '<div class="contact-avatar">';
                            OtherMessage += '<img src="'+profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary">';
                            OtherMessage += '</div>';
                            OtherMessage += '<div class="msg_container">';
                            OtherMessage += '<p class="mb-0">'+value.message+'</p>';
                            OtherMessage += '</div>';    
                            OtherMessage += '</div>';
                            OtherMessage += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+value.display_time+'</span>';
                            OtherMessage += '</div>';
                            OtherMessage += '</div>';
                            OtherMessage += '</li>';
                            $(".msg_card_body").prepend(OtherMessage);
                            
                            //appendUserchat(rowDocRes,'user','');
                        // }
                        
                        console.log('arvind message is here',profile_photo_path,value);
                    }
                }
                if (data.length - 1 == key) {     
                    if (chat_date == moment().format('DD-MMM-YYYY')) {
                        $(".msg_card_body").prepend('<li class="di__chat_date"><div class="d-flex justify-content-center align-items-center di__speratror"><p class="mb-0 lst_ur_msg_dt">'+chat_date+' </p></div></li>');
                    } else {
                        $(".msg_card_body").prepend('<li class="di__chat_date"><div class="d-flex justify-content-center align-items-center di__speratror"><p class="mb-0">'+chat_date+' </p></div></li>');
                    }
                }
                
                
                
               
            });
            if (response.current_page >= response.last_page) {
                on_top = true;
            }
            if (from_scroll) {
                $('.chat-history-main').scrollTop(0);
            } else {
                $('.chat-history-main').scrollTop($('.chat-history-main')[0].scrollHeight);
            }
            
            // if (from_scroll) {
            //     $('.msg_card_body').scrollTop(0);
            // } else {
            //     $('.msg_card_body').scrollTop($('.msg_card_body')[0].scrollHeight);
            // }
                
            $('#message').prop('disabled', false);
        
        },
        complete: function (response) {
            $('#message').prop('disabled', false);
            processing = false;
        }
    });
}

///// File attachment code

function getGroupChat(group_id, page = 1, from_scroll = false, user_change = true)
{
    $('#message').prop('disabled', true);
    $('#group_msg_' + group_id).html('');
    if (user_change) {
        $(".msg_card_body").html('');
    }
    let url = chat_group_route;
        url = url.replace(':id', group_id);
    $.ajax({
        url: url,
        method: 'GET',
        data: { page: page },
        beforeSend: function (response) {
            processing = true;
        },
        success: function (response) {
            $('#chat_user_messages_count').html(response.total);
            if (typeof response.paginate_data != 'undefined') {
                var data = response.paginate_data;
            } else {
                var data = response.data;
            }
            var chat_date = '';

            $.each(data, function (key, value) {
                var chat_time = value.display_time;
                var toDt = moment.utc(value.display_date, "YYYY-MM-DD'T'HH:mm:ss.SSSSSS'Z'").toDate();
                var chat_date_pre = chat_date;
                chat_date = moment(toDt).format('DD-MMM-YYYY');
                if (chat_date != chat_date_pre) {
                    if (chat_date_pre != '') {
                        if (chat_date_pre == moment().format('DD-MMM-YYYY')) {
                            $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+chat_date_pre+'</p></div>');
                        } else {
                            $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p>'+chat_date_pre+'</p></div>');
                        }
                    }
                }

                if (typeof value.documents !== 'undefined') {
                    $.each(value.documents, function (index, document) {
                        let rowDocRes = [];
                        var lstDocRows = new Array();
                        rowDocRes.message = document.document_url;
                        rowDocRes.document_name = document.document;
                        rowDocRes.time = chat_time;
                        console.log("Profile img=",value);
                        rowDocRes.profile_photo_path = value.vendor.profile_url;
                        lstDocRows.push(rowDocRes);
                        if (value.from == from_user.id) {
                            if (checkImage(rowDocRes.message)) {
                                appendUserchat(lstDocRows,'self','img','prepend','grp');                              
                            } else if (checkVideo(rowDocRes.message)) {
                                appendUserchat(lstDocRows,'self','video','prepend','grp');
                            } else if (checkAudio(rowDocRes.message)) {
                                appendUserchat(lstDocRows,'self','audio','prepend','grp');
                            } else {
                                appendUserchat(lstDocRows,'self','doc','prepend','grp');
                            }
                        } else {
                            if (checkImage(rowDocRes.message)) {
                                appendReceivedMessageForOtherUser(lstDocRows,'img','prepend');
                                // appendUserchat(lstDocRows,'user','img','prepend','grp');
                            } else if (checkVideo(rowDocRes.message)) {
                                appendReceivedMessageForOtherUser(lstDocRows,'video','prepend');
                                // appendUserchat(lstDocRows,'user','video','prepend','grp');
                            } else if (checkAudio(rowDocRes.message)) {
                                appendReceivedMessageForOtherUser(lstDocRows,'audio','prepend');
                                // appendUserchat(lstDocRows,'user','audio','prepend','grp');
                            } else {
                                appendReceivedMessageForOtherUser(lstDocRows,'doc','prepend');
                                // appendUserchat(lstDocRows,'user','doc','prepend','grp');
                            }
                        }
                    });
                }
                if (value.message != '') {
                    
                    let rowRes = [];
                    var lstRows = new Array();
                    rowRes.message = value.message;
                    // rowRes.message = value.decrypted_msg;
                    
                    rowRes.time = chat_time;
                    rowRes.profile_photo_path = value.vendor.profile_url;
                    lstRows.push(rowRes);
                    if (value.message_type == 1) {
                        $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p>'+value.message+'</p></div>');
                    } else {
                        if (value.from == from_user.id) {
                            console.log("grp message self prepend = ",lstRows);
                            appendUserchat(lstRows,'self','','prepend','grp');
                        } else {
                            console.log("grp message user prepend = ",value.message);
                            // appendUserchat(lstRows,'user','','prepend','grp');
                            appendReceivedMessageForOtherUser(lstRows,'','prepend');
                        }
                    }
                }
                if (data.length - 1 == key) {
                    if (chat_date == moment().format('DD-MMM-YYYY')) {
                        $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p class="lst_gp_msg_dt">'+chat_date+'</p></div>');
                    } else {
                        $(".msg_card_body").prepend('<div class="d-flex justify-content-center"><p>'+chat_date+'</p></div>');
                    }
                }
            });
            if (response.current_page >= response.last_page) {
                on_top = true;
            }
            if (from_scroll) {
                $('.msg_card_body').scrollTop(25);
            } else {
                $('.msg_card_body').scrollTop($('.msg_card_body')[0].scrollHeight);
            }

            $('#message').prop('disabled', false);
        },
        complete: function (response) {
            $('#message').prop('disabled', false);
            processing = false;
        }
    });
}

// $(document).ready(function () {
//     if ($('.chat-user').not('.d-none').length == 0) {
//         $('.no_records_found').removeClass('d-none');
//     } else {
//         $('.no_records_found').addClass('d-none');
//     }
// });

function appendReceivedMessageForOtherUser(chat_data,display_type='',append_type='append')
{
    
    var chat_data = chat_data[0];
    console.log("For profile image test ",chat_data);
    if(display_type == 'doc')
    {
        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
        Message +='<div class="d-flex align-items-start gap-3">';
        Message +='<div class="contact-avatar"><img src="'+chat_data.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
        Message += '<div class="msg_container"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0">'+chat_data.message+'</p></a></div>';
        Message += '</div>';
        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span>';
        Message += '</div></div></li>';
        //$(".msg_card_body").append(Message);
        
    } else if(display_type == 'img') {  
        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
        Message +='<div class="d-flex align-items-start gap-3">';
        Message +='<div class="contact-avatar"><img src="'+chat_data.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
        Message += '<div class="msg_container"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><img class="chat_image" width="200px;" height="200px;" src="'+chat_data.message+'"></img></p></a></div>';
        Message += '</div>';
        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span>';
        Message += '</div></div></li>';
        //$(".msg_card_body").append(Message);
    }
    else if(display_type == 'audio') {
        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
        Message +='<div class="d-flex align-items-start gap-3">';
        Message +='<div class="contact-avatar"><img src="'+chat_data.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
        Message += '<div class="msg_container"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><audio class="" src="'+chat_data.message+'" controls crossorigin></audio></p></a></div>';
        Message += '</div>';
        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span>';
        Message += '</div></div></li>';
        //$(".msg_card_body").append(Message);
    }
    else if(display_type == 'video') {
        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
        Message +='<div class="d-flex align-items-start gap-3">';
        Message +='<div class="contact-avatar"><img src="'+chat_data.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
        Message += '<div class="msg_container"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><video class="chat_image" src="'+chat_data.message+'" controls crossorigin></video></p></a></div>';
        Message += '</div>';
        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span>';
        Message += '</div></div></li>';
        //$(".msg_card_body").append(Message);
    }
    else{
        var Message = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
        Message +='<div class="d-flex align-items-start gap-3">';
        Message +='<div class="contact-avatar"><img src="'+chat_data.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
        Message += '<div class="msg_container"><p class="mb-0">'+chat_data.message+'</p></div>';
        Message += '</div>';
        Message += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span>';
        Message += '</div></div></li>';
        
        //$(".msg_card_body").append(Message);
    }
    if(append_type=='prepend')
    {
        $(".msg_card_body").prepend(Message);
    }
    else{
        $(".msg_card_body").append(Message);
    }
    
}
function appendUserchat(chat_data,display_type,doc_type='',renderType='prepend',chat_type='')
{
    if(chat_type == 'grp'){
        var chat_data = chat_data[0];
    }
    // var chat_time = chat_data.time;
    if(display_type=='self')
    {
        if(doc_type == 'doc')
        {
            var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0">'+chat_data.message+'</p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        else if(doc_type == "img")
        {
            var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><img class="chat_image" width="200px;" height="200px;" src="'+chat_data.message+'"></img></p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").append(selfMessage);
        }else if(doc_type == "audio")
        {
            var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><audio class="" src="'+chat_data.message+'" controls crossorigin></audio></p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        else if(doc_type == "video")
        {
            var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><video class="chat_image" src="'+chat_data.message+'" controls crossorigin></video></p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        else
        {
            var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><p class="mb-0">'+chat_data.message+'</p><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        if(renderType=='append')
        {
            $(".msg_card_body").append(selfMessage);
        }
        else
        {
            $(".msg_card_body").prepend(selfMessage);
        }
    }
    
    if(display_type=='user')
    {
        if(doc_type == 'doc')
        {
            var selfMessage = '<li class="clearfix"><div class="message user-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0">'+chat_data.message+'</p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        else if(doc_type == "img")
        {
            var selfMessage = '<li class="clearfix"><div class="message user-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><img class="chat_image" width="200px;" height="200px;"  src="'+chat_data.message+'"></img></p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }else if(doc_type == "audio")
        {
            var selfMessage = '<li class="clearfix"><div class="message user-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><audio class="" src="'+chat_data.message+'" controls crossorigin></audio></p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        else if(doc_type == "video")
        {
            var selfMessage = '<li class="clearfix"><div class="message user-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
            selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+chat_data.message+'" target="_blank"><p class="mb-0"><video class="chat_image" src="'+chat_data.message+'" controls crossorigin></video></p></a><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
            // $(".msg_card_body").prepend(selfMessage);
        }
        else
        {
            var selfMessage = '<li class="clearfix"><div class="message user-message my-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
            selfMessage +='<div class="d-flex align-items-start gap-3">';
            selfMessage +='<div class="contact-avatar"><img src="'+chat_data.profile_photo_path+'" alt="avatar" width="45" height="45" class="rounded-circle bg-primary"></div>';
            selfMessage += '<div class="msg_container"><p class="mb-0">'+chat_data.message+'</p></div>';
            selfMessage += '</div>';
            selfMessage += '<span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span>';
            selfMessage += '</div></div></li>';
            
        
        
            // var selfMessage = '<li class="clearfix"><div class="message user-message"><div class="d-flex justify-content-start mb-2 chat_box position-relative">';
            // selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><p class="mb-0">'+chat_data.message+'</p><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_data.time+'</span></div></div></div></div></li>';
        }
        if(renderType=='append')
        {
            $(".msg_card_body").append(selfMessage);
        }
        else
        {
            $(".msg_card_body").prepend(selfMessage);
        }
    }
}

function uploadFile(files) {
    var formData = new FormData();
    var error = 0;
    $.each(files, function (index, value) {
        if (value == 0 || value.size >= 25600000) {
            error = 1;
            // toastr.error('File size exceeds maximum limit 25 MB.');
            alert('File size exceeds maximum limit 25 MB.');
            return false;
        }
        formData.append('documents[]', value);
    });
    formData.append('_token', csrf_token);
    $.ajax({
        url: chat_store_media,
        type: 'POST',
        data: formData,
        global: false,
        contentType: false,
        processData: false,
        beforeSend : function(xhr, opts){
            if (error) {
                xhr.abort();
                return false;
            }
        },
        success: function(response) {
            let message = $('#message').val().trim();
            var uuid = new Date().getTime() + from_user.id;
            if (chat_user == null || chat_user == '') {
                // encodeString(message, function(encode_message) {
                    socket.emit('vendorGroupMessage', { message: message, message_type:0, from: from_user, send_group: chat_group, uuid: uuid, documents : response.documents });
                // });
                $('#chat-group-'+chat_group.id+'').find('p.group_last_msg').text(from_user.name +': '+ message);
            } else {
                // encodeString(message, function(encode_message) {
                    socket.emit('vendorMessage', { message: message, from: from_user, send: chat_user, uuid: uuid, documents : response.documents });
                    //socket.emit('vendorMessage', { message: _message, from: from_user, send: chat_user, uuid: uuid });
                // });
                $('#chat-user-'+chat_user.id+'').find('p.user_last_msg').text(message);
            }
            if (typeof response.documents !== 'undefined') {
                $.each(response.documents, function (index, document) {
                    
                    
                    let rowDocRes = [];
                    var lstDocRows = new Array();
                    rowDocRes.message = document.link;
                    rowDocRes.document_name = document.name;
                    rowDocRes.time = moment().format('HH:mm');
                    rowDocRes.profile_photo_path = from_user.profile_url;
                    lstDocRows.push(rowDocRes);
                                    
                    if (checkImage(rowDocRes.message)) {
                        appendUserchat(rowDocRes,'self','img','append');
                        // $(".msg_card_body").append($.tmpl($("#jsSelfImageTemplate").html(), lstDocRows));
                    } else if (checkVideo(rowDocRes.message)) {
                        appendUserchat(rowDocRes,'self','video','append');
                        // $(".msg_card_body").append($.tmpl($("#jsSelfVideoTemplate").html(), lstDocRows));
                    } else if (checkAudio(rowDocRes.message)) {
                        appendUserchat(rowDocRes,'self','audio','append');
                        // $(".msg_card_body").append($.tmpl($("#jsSelfAudioTemplate").html(), lstDocRows));
                    } else {      
                        appendUserchat(rowDocRes,'self','doc','append');
                        
                        //var selfMessage = '<li class="clearfix"><div class="message my-message"><div class="d-flex justify-content-end mb-2 chat_box"><div class="msg_container"><div class="d-flex align-items-end gap-2"><a href="'+lstDocRows[0].message+'" target="_blank"><p class="mb-0">'+lstDocRows[0].document_name+'</p></a><span class="text-sm-10 mb-0">'+lstDocRows[0].time+'</span></div></div></div></div></li>';
                       // $(".msg_card_body").append(selfMessage);
                        // $(".msg_card_body").append($.tmpl($("#jsSelfDocumentTemplate").html(), lstDocRows));
                    }
                    
                    
                    if (chat_user == null || chat_user == '') {
                        $('#chat-group-'+chat_group.id+'').find('p.group_last_msg').text(from_user.name +': '+ document.name);
                    } else {
                        $('#chat-user-'+chat_user.id+'').find('p.user_last_msg').text(document.name);
                    }
                });
                $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
            }
            if (message) {
                let rowRes = [];
                var lstRows = new Array();
                rowRes.message = message;
                rowRes.profile_photo_path = from_user.profile_url;
                rowRes.time = moment().format('HH:mm');
                var chat_time = moment().format('HH:mm');
                lstRows.push(rowRes);
               // $(".msg_card_body").append($.tmpl($("#jsSelfTemplate").html(), lstRows));
                
                var selfMessage = '<li class="clearfix"><div class="message reply-message"><div class="d-flex justify-content-end mb-2 chat_box position-relative">';
                selfMessage += '<div class="msg_container"><div class="d-flex align-items-end gap-2"><p class="mb-0">'+message+'</p><span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">'+chat_time+'</span></div></div></div></div></li>';
                $(".msg_card_body").append(selfMessage);
            
                $('#message').val('');
                if (chat_user == null || chat_user == '') {
                    $('#chat-group-'+chat_group.id+'').find('p.group_last_msg').text(from_user.name +': '+ message);
                } else {
                    $('#chat-user-'+chat_user.id+'').find('p.user_last_msg').text(message);
                }
                $('#chat_user_messages_count').text(Number($('#chat_user_messages_count').text()) + 1);
            }
            $('#msg_card_body').stop().animate({
                scrollTop: $('#msg_card_body')[0].scrollHeight
            }, 1500);
        },
        error: function (response) {
            if (response.status == 422) {
                $.each(response.responseJSON.errors, function (index, value) {
                    //toastr.error(value);
                    alert('Error:'+value);
                });
            } else {
                //toastr.error("Something Went Wrong !");
                alert('Error: Something Went Wrong !');
            }
        }
    });
}


$(document).on('click', '#action_menu_btn', function() {
    $(this).siblings(".action_menu").toggle();
});
$(document).on('change', '#imageUpload', function() {
    if (this.files.length <= 10) {
        uploadFile(this.files);
    } else {
       // toastr.error('Max 10 Files upload at a time');
        alert('Max 10 Files upload at a time');
    }
});

function checkImage(url) {
	return(url.match(/\.(jpeg|jpg|gif|png|jfif)$/) != null);
}

function checkVideo(url) {
	return(url.match(/\.(mp4|avi|mkv)$/) != null);
}

function checkAudio(url) {
	return(url.match(/\.(mp3|wav|ogg)$/) != null);
}

socket.on('newGroupCreated', function(data) {
    $('.chat-user').removeClass('active');
    $('.chat-group').removeClass('active');
    var group_html = '<li class="d-flex justify-content-between chat-group active" id="chat-group-'+data.group_id+'" data-group="'+data.group_id+'">'
                        +'<div class="d-flex gap-2 gap-lg-3 align-items-center">'
                            +'<div class="contact-avatar group_profile">'
                                +'<div class="img-wrapper img_cont">'
                                    +'<img src="'+default_img_url+'"  class="rounded-circle bg-primary" width="39" height="39">'
                                    +'<div class="group-icon"><i class="fas fa-users" style="color:grey"></i></div>'
                                +'</div>'
                            +'</div>'
                                +'<div class="contacts__about">'
                                    +'<div class="group_info">'
                                        +'<p class="mb-0 fw-smedium" >'+data.group_name+'</span>'
                                    +'</div>'
                                    +'<div class="contact__msg">'
                                        +'<p class="group_last_msg"></p>'                                              
                                    +'</div>'
                                +'</div>'
                                +'<div class="msg_count" id="group_msg_'+data.group_id+'"></div>'
                        +'</div>'
                    +'</li>';    
    $('#contact-list').prepend(group_html);
    $('#chat-group-'+data.group_id+'').click();
});

socket.on('groupMemberChanged', function(data) {
    if (data.mode == 'group_name_changed') {
        $('#chat-group-'+data.group_id+'').find('div.group_info span').text(data.group_name);
        $('#add_group_member_'+data.group_id+'').find('#group_name_join').val(data.group_name);
        $('#chat-group-'+data.group_id+'').find('div.img_cont img').attr('src', data.group_pro_url);
        var first_grp = $('#contact-list').find('#chat-group-'+data.group_id+'');
        first_grp.remove();
        $('#contact-list').prepend(first_grp);
        $('#chat-group-'+data.group_id+'').click();
    } else if (data.mode == 'member_added') {
        $('.chat-user').removeClass('active');
        $('.chat-group').removeClass('active');
        var group_html = '<li class="d-flex justify-content-between chat-group active" id="chat-group-'+data.group_id+'" data-group="'+data.group_id+'">'
                            +'<div class="d-flex gap-2 gap-lg-3 align-items-center">'
                                +'<div class="contact-avatar group_profile">'
                                    +'<div class="img-wrapper img_cont">'
                                        +'<img src="'+default_img_url+'"  class="rounded-circle bg-primary" width="39" height="39">'
                                        +'<div class="group-icon"><i class="fas fa-users" style="color:grey"></i></div>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="contacts__about">'
                                    +'<div class="group_info">'
                                        +'<p class="mb-0 fw-smedium">'+data.group_name+'</p>'
                                    +'</div>'
                                    +'<div class="contact__msg">'
                                        +'<p class="group_last_msg"></p>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="msg_count" id="group_msg_'+data.group_id+'"></div>'
                            +'</div>'
                        +'</li>';                    
        $('#contact-list').prepend(group_html);
        $('#chat-group-'+data.group_id+'').click();
    } else if (data.mode == 'member_removed') {
        var group_to_remove = $('#contact-list').find('#chat-group-'+data.group_id+'');
        group_to_remove.remove();
        $('ui#contact-list li:first-child').click();
    } else if (data.mode == 'group_deleted') {
        var group_to_remove = $('#contact-list').find('#chat-group-'+data.group_id+'');
        group_to_remove.remove();
        $('ui#contact-list li:first-child').click();
    }
});

socket.on('groupUpdate', function(data) {
    $.ajax({
        type: 'GET',
        url: get_groups_route,
        success: function (response) {
            groups = response.data.groups;
        }
    });
    if (data.group_id == chat_group.id) {
        $('#chat-group-'+data.group_id+'').click();
    } else {
        var cont = $('#group_msg_' + data.group_id).html();
        if (cont == '' || cont == null || cont == 'undefined' || isNaN(cont)) {
            cont = 0;
        }
        cont = parseInt(cont) + 1;
        $('#group_msg_' + data.group_id).html(cont);
    }
});

