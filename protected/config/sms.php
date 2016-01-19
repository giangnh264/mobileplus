<?php
	return array(
       'params'=>array(
			'subscribe' => array(
				'invalid_params' => 'Parameter is incorrect', //for webservices
				'success' => 'Bạn đã đăng ký thành công gói cước {PACKAGE} mật khẩu đăng nhập của bạn là {PASSWORD}. Cảm ơn bạn!',
	            'package_not_exist' => 'Package that you have registered does not exist in the system. Please try again later.',
	            'duplicate_package' => 'Gói cước bạn đăng ký trùng với gói cước đang sử dụng. Xin vui lòng thử lại hoặc gọi số 18001091(miễn phí) để được hỗ trợ.',    		        	
	            'update_subscribe_user_failed' => 'Hệ thống tạm thời gián đoạn. Xin vui lòng đăng ký lại sau. Xin cảm ơn',
	            'default' => 'Cannot create new user account. Please try again later',				
	            'user_exits' => 'Số điện thoại đã đăng ký. Soạn MK1 gửi 9234 để lấy lại mật khẩu',	
                    'duplicate_package_g2'=>'Gói cước bạn đăng ký trùng với gói cước đang sử dụng',
                    'duplicate_package_g3'=>'Gói cước bạn đăng ký trùng với gói cước đang sử dụng',
                    'duplicate_package_g4'=>'Gói cước bạn đăng ký trùng với gói cước đang sử dụng',
                            
        	),
        	'unsubscribe' => array(
            	'invalid_params' => 'Parameter is incorrect',
        		'success' => 'You have unregistered successfully. To register again, Please send ON(Daily package), ON1(Weekly Package), ON2(Monthly package) to 130. Thank you.',
        		'subscribe_user_not_exist' => 'You have not registered yet. Type ON send to 130 to register. For more service information, visit http://3g.imuzik.com.kh or call 1779 (1c/min) for more assistance.',
        	),
        	'song' => array(
        		'song_not_exist' => 'This song is not available or has been removed',
        	),
        	'video' => array(
        		'video_not_exist' => 'This video is not available or has been removed',
        	),
        	'charging' => array(
        		'success' => 'Successful transaction',
        		'transaction_forbidden' => 'There was an error occurred during the system process. Please try again later',//'Lỗi hệ thống, không thể thực hiện giao dịch',
        	),
        	'downloadSong'=>array(
        		'error' => 'Your basic balance has not enough to use this service',//'Tài khoản của bạn không đủ để thực hiện thao tác này',
        		'song_not_exist' => 'This song is not available or has been removed',
        		'default' => 'There was an error occurred during the system process. Please try again later',//'Lỗi hệ thống, không thể thực hiện giao dịch',
        	),
        	'playSong'=>array(
        		'error' => 'Your basic balance has not enough to use this service',//'Tài khoản của bạn không đủ để thực hiện thao tác này',
        		'default' => 'There was an error occurred during the system process. Please try again later',//'Lỗi hệ thống, không thể thực hiện giao dịch',
        	),
        	'downloadVideo'=>array(
        		'error' => 'Your basic balance has not enough to use this service',//'Tài khoản của bạn không đủ để thực hiện thao tác này',
        		'default' => 'There was an error occurred during the system process. Please try again later',//'Lỗi hệ thống, không thể thực hiện giao dịch',
        	),
        	'playVideo'=>array(
        		'error' => 'Your basic balance has not enough to use this service',//'Tài khoản của bạn không đủ để thực hiện thao tác này',
        		'default' => 'There was an error occurred during the system process. Please try again later',//'Lỗi hệ thống, không thể thực hiện giao dịch',
        	),
        	'detectMSISDN'=>'System can not identify your phone',
           //for receiveMo
        	'MO'=>array(
        		'basicPackage'=>'1',
        		'advancePackage'=>'2',
        		'hd'=>'De su dung DV tiet kiem,hay dang ky goi cuoc.Goi co ban,soan DK gui 1226.Goi nang cao,soan DKS gui 1226.Tai bai hat,soan BH_tenbaihat gui 1226(1000đ/bai)',
        		'hd2'=>'De su dung dich vu tot nhat,dien thoai cua quy khach can ho tro 3G. Truy nhap: 3g.imuzik.com.vn de su dung dich vu. Lien he 1818 (mien phi) de duoc ho tro',
        		'hdcuoc'=>'Goi co ban:10000d/thang,mien phi data streaming 3h,mua gio 3000d/h.Goi nang cao:30000d/thang,tu thang thu 2 duoc mien phi 100SMS,mien phi data khong han muc',
        		'authenticate_failed'=>'You are not allowed to access',
        		
        	),   
        	
           
        )
	);
//);

/*
return array(
	'0' => 'Đăng ký thành công',
	'0101' => 'Tham số truyền vào không đúng',
	'0102' => 'Gói cước đăng ký không tồn tại',
	'0103' => 'Đăng ký trùng gói cước',
	'0104' => 'Lỗi hệ thống, không thể tạo tài khoản mới',
	'0105' => 'Không thể thực hiện giao dịch',
	'0106' => 'Hủy đăng ký thành công',
	'0107' => 'Thuê bao chưa đăng ký gói cước',	
);
*/
