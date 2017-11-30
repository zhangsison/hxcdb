<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    ?>


  wx.config({
              debug: false,
                appId: '<?php echo $jssdk['appId']; ?>',
              timestamp: <?php echo $jssdk['timestamp']; ?>,
              nonceStr: '<?php echo $jssdk['nonceStr']; ?>',
              signature: '<?php echo $jssdk['signature']; ?>',
              jsApiList: [
                  // 所有要调用的 API 都要加到这个列表中
                  'checkJsApi',
                  'openLocation',
                  'getLocation',
                  'onMenuShareTimeline',
                  'onMenuShareAppMessage',
                  'scanQRCode'
                ]
          });
wx.ready(function () {
  //分享给朋友
      wx.onMenuShareAppMessage({
      title: '这是分享的标题',
      desc: '这是分享的描述',
      link: 'http://mpp.sohunjug.com',
      imgUrl: 'http://images.cnitblog.com/i/340216/201404/301756448922305.jpg',

      success: function (res) {
    
      },
      cancel: function (res) {
        alert('很遗憾，您已取消分享');
      },
     
    });

  //分享到朋友圈
    wx.onMenuShareTimeline({
       title: '这是分享的标题',
      link: 'http://mpp.sohunjug.com',
      imgUrl: 'http://images.cnitblog.com/i/340216/201404/301756448922305.jpg',
    });



  



});


