class NotificationPoper {
        constructor(serviceURL, refreshRate, postRefreshCallback = null, params = {}) {
            this.serviceURL = serviceURL;
            this.postRefreshCallback = postRefreshCallback;
            this.refreshRate = refreshRate * 1000;
            this.paused = false;
            this.params = params;
            this.refresh(true);
            setInterval(() => {
                this.refresh()
            }, this.refreshRate);
        }
        static setEndSessionAction(action) {
            EndSessionAction = action;
        }
        pause() {
            this.paused = true
        }

        restart() {
            this.paused = false
        }

        notify(list) {
            if (list.length > 0) {
                let array = JSON.parse(list);
                //console.log(typeof(array),array);
                console.log(array);
                
                for(var key in array){
                    console.log(array[key]);
                    let message = JSON.parse(array[key]['mcontent'])['msg'].replace(/(<(br)>)/gi,", ");
                    message = message.replace(/(<\/?b>)/gi,'');
                    let title = JSON.parse(array[key]['mcontent'])['title'].replace(/(<([^>]+)>)/gi, " ");;
                    Toastify({
                        text: title+' : '+message,
                        duration: 5000,
                        // destination: element['notificationLink'],
                        position: "center",
                        gravity: "bottom",
                        close:true,
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "#008000",
                            borderRadius:"15px",
                            fontSize:'20px',
                        },
                    }).showToast();
                }


                // array.forEach(element => {        
                //     //let message = JSON.parse(element['mcontent'])['msg'].replace(/(<([^>]+)>)/gi, "");;      
                //     console.log(element);      
                    
                // });
                
                if (this.postRefreshCallback != null) this.postRefreshCallback();
            }
        }

        static redirectToEndSessionAction() {
            console.log(this.EndSessionAction)
            window.location = this.EndSessionAction;
        }

        refresh(forced = false) {
            if (!this.paused) {
                $.ajax({
                    url: this.serviceURL + (forced ? (this.serviceURL.indexOf("?") > -1 ? "&" : "?") +
                        "forceRefresh=true" : ""),
                    dataType: "html",
                    success: (list) => {
                        this.notify(list)
                    },
                    statusCode: {
                        408: function() {
                            if (EndSessionAction != "")
                                window.location = EndSessionAction + "?xalert=Session expirée";
                            else
                                alert("Time out occured!");
                        },
                        401: function() {
                            if (EndSessionAction != "")
                                window.location = EndSessionAction + "?xalert=Access illégal";
                            else
                                alert("Illegal access!");
                        },
                        403: function() {
                            if (EndSessionAction != "")
                                window.location = EndSessionAction + "?xalert=Compte bloqué";
                            else
                                alert("Illegal access!");
                        }
                    }
                })
            }
        }

        command(url, moreCallBack = null) {
            $.ajax({
                url: url,
                method: 'GET',
                success: () => {
                    this.refresh(true);
                    if (moreCallBack != null)
                        moreCallBack();
                }
            });
        }

        confirmedCommand(message, url, moreCallBack = null) {
            bootbox.confirm(message, (result) => {
                if (result) this.command(url, moreCallBack)
            });
        }
    }
$(()=>{

    let init = new NotificationPoper("/api/notifications",5);
    

})