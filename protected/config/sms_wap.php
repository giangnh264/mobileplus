<?php

//return CMap::mergeArray(
//    require(dirname(__FILE__).'/main.php'),
return array(
    'params' => array(
        'subscribe' => array(
            'invalid_params' => 'Parameter is incorrect', //for webservices
            'success' => 'You have register successfully the Imuzik3G service. For more assistance, please visit: http://3g.imuzik.com.kh or call 1779 (1c/min). Thank you!',
            'success_a1' => 'Quy khach da dang ky thanh cong goi A1 dich vu Amusic cua MobiFone, gia 2.000d/ngay, tu dong gia han.  De huy dich vu soan HUY A1 gui 9166. Truy cap http://amusic.vn de nghe xem tai cac bai hat, Clip ca nhac dac sac nhat hien nay (hoan toan mien phi cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_a7' => 'Quy khach da dang ky thanh cong goi A7 dich vu Amusic cua MobiFone, gia 7.000d/ tuan, tu dong gia han. De huy dich vu soan HUY A7 gui 9166. Truy cap http://amusic.vn  de nghe xem tai cac bai hat, Clip ca nhac dac sac nhat hien nay (hoan toan mien phi cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_km_a1' => 'Chuc mung, Quy khach duoc MIEN PHI 05 ngay nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay tai dich vu Amusic cua MobiFone (sau KM 2.000d/ngay), de huy dich vu soan HUY A1 gui 9166. Hay cap nhat lien tuc cac bai hat, Clip ca nhac dac sac nhat hien nay tai http://amusic.vn (hoan toan mien phi cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on !',
            'success_km_a7' => 'Chuc mung, Quy khach duoc MIEN PHI 05 ngay nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay tai dich vu Amusic cua MobiFone (sau KM 7.000d/tuan), de huy dich vu soan HUY A7 gui 9166. Hay cap nhat lien tuc cac bai hat, Clip ca nhac dac sac nhat hien nay tai http://amusic.vn (hoan toan mien phi cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on !',

            'duplicate_package_a1' => 'Quy khach hien dang su dung goi A1 - 2000d/ngay, co thoi han den :EXPIRED. Truy cap http://amusic.vn de thuong thuc MIEN PHI cac bai hat va clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'duplicate_package_a7' => 'Quy khach hien dang su dung goi A7 - 7000d/tuan, co thoi han den :EXPIRED. Truy cap http://amusic.vn de thuong thuc MIEN PHI cac bai hat va clip ca nhac HOT nhat hien nay. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'balance_too_low' => 'Tài khoản của Quý khách không đủ để đăng ký gói [Tengoi]. Vui lòng nạp thêm tiền vào đăng ký.',
        	'balance_too_low_a1' => 'Xin loi, tai khoan cua quy khach khong du tien. Vui long nap them tien vao tai khoan de dang ky dich vu hoac soan tin DK A1 gui 9166 (2.000 d/ngay), DK A7 gui 9166 (7.000d/tuan). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'balance_too_low_a7' => 'Xin loi, tai khoan cua quy khach khong du tien. Vui long nap them tien vao tai khoan de dang ky dich vu hoac soan tin DK A1 gui 9166 (2.000 d/ngay), DK A7 gui 9166 (7.000d/tuan). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        	'fail_feedata' => 'Hien he thong dang ban. Quy khach vui long thu lai sau. Tran trong cam on!',

            'success_otp_password' => 'Ban vua thuc hien thao tac lay mat khau tren dich vu Amusic, ma xac thuc cua ban la :OTP. Luu y: Ma xac thuc chi co hieu luc trong vong 24h.',
            'success_password' => 'Mat khau cua tai khoan :PHONE tren dich vu Amusic la :PASS. Moi quy khach dang nhap http://amusic.vn de su dung. Luu y: Mat khau chi co hieu luc trong vong 24h.',
            'success_send_password' =>'Mat khau cua tai khoan :PHONE tren dich vu Amusic la :PASS. Moi quy khach dang nhap http://amusic.vn de su dung. Luu y: Mat khau chi co hieu luc trong vong 24h.',
            'success_create_account' => 'Quy khach dang thuc hien dang ky tai khoan tren website http://amusic.vn. Ma xac nhan cua quy khach la :OTP',
            'package_not_exist' => 'Goi cuoc ban dang ky khong ton tai tren he thong, vui long soan tin DK A1 gui 9166 (2.000 d/ngay), DK A7 gui 9166 (7.000d/tuan). Truy cap http://amusic.vn de biet them chi tiet. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            
        		
            'success_msg_am' => 'Quý khách đang sử dụng gói AM. Qúy khách được hoàn toàn Miễn cước 3G/GPRS khi xem các clip ca nhạc HOT nhất tại gói âm nhạc của MobiFone',
            'success_msg_km_am' => 'Quý khách đang sử dụng gói AM. Qúy khách được Miễn phí 07 ngày nghe bài hát và xem các clip ca nhạc HOT nhất hiện nay. Đặc biệt hoàn toàn Miễn cước 3G/GPRS',
            'success_msg_am7' => 'Quý khách đang sử dụng gói AM7. Qúy khách được hoàn toàn Miễn cước 3G/GPRS khi xem các clip ca nhạc HOT nhất tại gói âm nhạc của MobiFone',
            'success_msg_km_am7' => 'Quý khách đang sử dụng gói AM. Qúy khách được Miễn phí 07 ngày nghe bài hát và xem các clip ca nhạc HOT nhất hiện nay. Đặc biệt hoàn toàn Miễn cước 3G/GPRS',
            'update_subscribe_user_failed' => 'Sorry. An error occurred during subcribe process. Please try again later',//'Có lỗi trong quá trình đăng ky, mời bạn quay lại sau ít phút',
            
            'default' => 'Co loi trong qua trinh tao tai khoan, vui long thu lai sau. Xin cam on.',
            'reset_password'=>'Mat khau su dung dich vu Amusic cua thue bao {:PHONE} la: {:PASSWORD}.',
            'reset_password'=>'Mat khau cua tai khoan {:PHONE} tren dich vu Amusic la {:PASSWORD}. Moi quy khach dang nhap http://amusic.vn de su dung. Luu y: Mat khau chi co hieu luc trong vong 24h.',
            'require_unsubscribe' => '',
            'is_not_mobifone_number'=>'Số điện thoại của bạn phải là thuê bao của Mobifone mới có thể đăng ký được gói cước.',
            'password_success_web'=>'Quy khach dang thuc hien dang ky tai khoan tren website http://amusic.vn/. Ma xac nhan cua quy khach la :PASS.',
            'subscribe_otp'=>'Quy khach dang thuc hien dang ky goi cuoc tren dich vu Amusic http://amusic.vn. Ma xac nhan cua Quy khach la :OTP.',
            'create_account_otp'=>'Quy khach dang thuc hien dang ky tai khoan tren dich vu Amusic. Ma xac nhan cua quy khach la  :OTP.'
        ),
        'subcsriber_wap'=>array(
            'balance_too_low' => 'Tài khoản của bạn không đủ tiền để đăng ký dịch vụ Amusic, vui lòng nạp thêm tiền để sử dụng dịch vụ. Xin cảm ơn!',
            'balance_too_low_a1' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói ngày A1 (2000đ/ngày). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'balance_too_low_a7' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói tuan A7 (7000đ/tuần). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'duplicate_package_a1'=>'Quý khách đang sử dụng gói A1. Vui lòng hủy gói đang sử dụng trước.',
            'duplicate_package_a7'=>'Quý khách đang sử dụng gói A7. Vui lòng hủy gói đang sử dụng trước.',

        ),
        'subscribe_msg'=>array(
            'success'=>'Quý khách đã đăng ký thành công gói Tengoi. Quý khách được hoàn toàn Miễn cước 3G/GPRS khi sử dụng điện thoại xem các clip ca nhạc HOT nhất tại gói âm nhạc của MobiFone.',
            'unsuccess'=>'Tài khoản của Quý khách không đủ để đăng ký gói [Tengoi]. Vui lòng nạp thêm tiền vào đăng ký.',
            'success_km_a1'=>'Quý khách đã đăng ký thành công gói A1. Quý khách được Miễn phí 05 ngày nghe xem tải không giới hạn các bài hát và Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS.',
            'success_km_a7'=>'Quý khách đã đăng ký thành công gói A7. Quý khách được Miễn phí 05 ngày nghe xem tải không giới hạn các bài hát và Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS.',
            'success_a1'=>'Quý khách đã đăng ký thành công gói A1. Quý khách được nghe xem tải không giới hạn các bài hát, Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS',
            'success_a7'=>'Quý khách đã đăng ký thành công gói A7. Quý khách được nghe xem tải không giới hạn các bài hát, Clip ca nhạc HOT nhất hiện nay. Đặc biệt, dịch vụ hoàn toàn Miễn cước 3G/GPRS',
            'is_not_mobifone_number'=>'Số điện thoại của bạn phải là thuê bao của Mobifone mới có thể đăng ký được gói cước.',
            'balance_too_low' => 'Tài khoản của Quý khách không đủ để đăng ký gói [Tengoi]. Vui lòng nạp thêm tiền vào đăng ký.',
            'balance_too_low_a1' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói ngày A1 (2000đ/ngày). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'balance_too_low_a7' => 'Tài khoản của Quý khách không đủ tiền để đăng ký gói tuần A7 (7000đ/tuần). Mời Quý khách nạp thêm tiền vào tài khoản và đăng ký để sử dụng dịch vụ.',
            'duplicate_package_a1'=>'Quý khách đang sử dụng gói A1. Vui lòng hủy gói cước đang sử dụng để đăng ký gói A7.',
            'duplicate_package_a7'=>'Quý khách đang sử dụng gói A7. Vui lòng hủy gói cước đang sử dụng để đăng ký gói A1.',
            'default'=>'Hệ thống tạm thời có lỗi, Quý khách vui lòng thử lại sau ít phút. Trân trọng cảm ơn!'

        ),
        'subscribe_ext' => array(
            'success_am7' => 'Goi cuoc A7 dich vu Amusic cua Quy khach vua duoc gia han voi 7.000d/tuan den :EXPIRED. Truy cap http://amusic.vn de nghe, xem cac bai hat, MV dac sac nhat hien nay. Dich vu hoan toan mien phi cuoc GPRS/3G. Neu khong muon tiep tuc su dung, soan Huy Tengoi gui 9166 de huy dich vu. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'msg' => 'Dich vu Amusic cua MobiFone kinh moi Quy khach truy cap http://amusic.vn  de xem MIEN PHI cac bai hat, MV dac sac nhat hien nay. Dac biet dich vu mien phi hoan toan cuoc GPRS/3G. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'welcome_a7'=>'Dich vu Amusic cua MobiFone kinh moi Quy khach truy cap http://amusic.vn  de xem MIEN PHI cac bai hat, MV dac sac nhat hien nay. Dac biet dich vu mien phi hoan toan cuoc GPRS/3G. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        ),
        'unsubscribe' => array(
            'success_a1' => 'Quy khach da huy thanh cong goi A1 dich vu Amusic. De dang ky lai, soan "DK Tengoi" gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan) hoac truy cap http://amusic.vn de nghe va xem cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'success_a7' => 'Quy khach da huy thanh cong goi A7 dich vu Amusic. De dang ky lai, soan "DK Tengoi" gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan) hoac truy cap http://amusic.vn de nghe va xem cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G). Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'subscribe_user_not_exist' => 'Yeu cau huy dich vu khong thanh cong do Quy khach chua dang ky goi dich vu. Soan "DK Tengoi" gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan) de dang ky su dung dich vu Amusic cua MobiFone hoac truy cap http://amusic.vn de nghe xem tai cac bai hat va clip HOT nhat hien nay (mien cuoc GPRS/3G). Chi tiet goi 9090 (200d/phut). Tran trong cam on!',
            'error_default' => "Co loi trong qua trinh huy goi cuoc, vui long thu lại sau!",
//            'auto_unsub' => "Thoi han su dung dich vu nghe bai hat, xem clip ca nhac MIEN PHI cua khach hang da het han su dung. De dang ky lai su dung dich vu nghe nhac va xem video khong gioi han Quy khach vui long soan: DK Ten goi gui 9022 (Ten goi: AM hoac AM7) hoac goi 9090 de biet them chi tiet. Tran trong cam on!",
            'auto_unsub' => 'Xin loi, Goi :PACKAGE dich vu Amusic da bi huy do tai khoan cua quy khach khong du tien de tiep tuc su dung. Vui long nap them tien de tiep tuc su dung. De dang ky lai, soan "DK Tengoi" gui 9166 (Tengoi: A1, A7) Truy cap http://amusic.vn hoac goi 9090 (200d/phut) de biet them chi tiet. Tran trong cam on',
            'success_a1_msg'=>'Qúy Khách đã hủy thành công gói cước của dịch vụ Amusic. Để đăng ký lại dịch vụ, Quý Khách vui lòng soạn "DK Tengoi" gửi 9166 (Tên gói A1, A7) để đăng ký sử dụng dịch vụ nghe bài hát và xem clip ca nhạc không giới hạn của MobiFone. Truy cập http://amusic.vn để bắt đầu sử dụng dịch vụ (hoàn toàn miễn cước GPRS/3G). Chi tiết gọi 9090. Trân trọng cảm ơn!',
            'success_a7_msg'=>'Qúy Khách đã hủy thành công gói cước của dịch vụ Amusic. Để đăng ký lại dịch vụ, Quý Khách vui lòng soạn "DK Tengoi" gửi 9166 (Tên gói A1, A7) để đăng ký sử dụng dịch vụ nghe bài hát và xem clip ca nhạc không giới hạn của MobiFone. Truy cập http://amusic.vn để bắt đầu sử dụng dịch vụ (hoàn toàn miễn cước GPRS/3G). Chi tiết gọi 9090. Trân trọng cảm ơn!',
            'subscribe_user_not_exist_msg' => 'Bạn chưa đăng ký gói cước. De dang ky, soan "DK Tengoi" gui 9166 (Tengoi: A1, A7) hoac  truy cap http://amusic.vn de nghe, xem, tai cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G).',

        ),
        'unsubscribe_msg' => array(
            'error_default' => "Co loi trong qua trinh huy goi cuoc, vui long thu lại sau!",
            'auto_unsub' => "Thoi han su dung dich vu nghe bai hat, xem clip ca nhac MIEN PHI cua khach hang da het han su dung. De dang ky lai su dung dich vu nghe nhac va xem video khong gioi han Quy khach vui long soan: DK Ten goi gui 9022 (Ten goi: AM hoac AM7) hoac goi 9090 de biet them chi tiet. Tran trong cam on!",
            'success_a1'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'success_a7'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'subscribe_user_not_exist' => 'Yêu cầu hủy dịch vụ không thành công do Quý khách chưa đăng ký gói dịch vụ. Soạn "DK Tengoi" gửi 9166 (Tengoi: A1 - gói ngày, A7 - goi tuần) để đăng ký sử dụng dịch vụ Amusic của Mobifone hoặc truy cập http://Amusic.vn để nghe xem tải các bài hát va clip HOT nhất hiện nay (mien cuoc GPRS/3G). Chi tiết gọi 9090, trân trọng cảm ơn!',
            'success_a1_msg'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'success_a7_msg'=>'Quý khách đã hủy thành công gói cước của dịch vụ Amusic. Mời Quý khách đăng ký lại khi có nhu cầu nghe xem tải các bài hát, video ĐỘC QUYỀN và chất lượng cao nhất trên Amusic.',
            'subscribe_user_not_exist_msg' => 'Bạn chưa đăng ký gói cước. De dang ky, soan "DK Tengoi" gui 9166 (Tengoi: A1, A7) hoac  truy cap http://amusic.vn de nghe, xem, tai cac clip ca nhac dac sac nhat hien nay (mien cuoc GPRS/3G).',



        ),
        'subscribe_ext_notify' => array(
            'a1' => 'Quy khach chi con 02 ngay su dung MIEN PHI goi A1 tren Amusic, goi cuoc se tu dong gia han voi muc cuoc 2.000/ngay tu ngay :EXPIRED_TIME. Truy cap dich vu tai http://amusic.vn de tham gia cac su kien hap dan chi co tren dich vu Amusic. Neu khong muon tiep tuc su dung dich vu, soan HUY A1 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'a7' => 'Quy khach chi con 02 ngay su dung MIEN PHI goi A7 tren Amusic, goi cuoc se tu dong gia han voi muc cuoc 7.000/tuan tu ngay :EXPIRED_TIME. Truy cap dich vu tai http://amusic.vn de tham gia cac su kien hap dan chi co tren dich vu Amusic. Neu khong muon tiep tuc su dung dich vu, soan HUY A7 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
        ),
        'sms_help' => "De nghe xem tai cac bai hat, MV dac sac DOC QUYEN tai Amusic va mien cuoc 3G/GPRS khi su dung, soan DK Tengoi gui 9166 (Tengoi: A1 - 2000d/ngay, A7 - 7000d/ tuan). De kiem tra goi cuoc soan KT gui 9166. De biet gia cuoc soan GIA gui 9166. De huy soan HUY Tengoi gui 9166 hoac truy cap http://amusic.vn de biet them chi tiet. Chi tiet goi 9090 (200d/phut). Tran trong cam on!",
        'wrongSms' => 'Quy khach vua nhap cu phap chua dung. De xem Clip HOT soan DK MC1 gui 9022. De xem PHIM soan DK PHIM gui 9022. De xem Clip thoi trang lam dep soan DK STV gửi 9022. De xem Clip hai huoc soan DK HAI gui 9022. De xem Clip Am nhac soan DK AM gui 9022. De kiem tra goi cuoc soan KT gui 9022. De biet gia cuoc soan GIA gui 9022. De huy soan HUY Tengoi gui 9022 hoac truy cap http://mobiclip.vn/music de biet them chi tiet.',
        'smsWSDL' => 'http://10.1.10.67:8080/api/soap',
        'error_limit' => 'Quý khách đã nghe(xem) hết 5 lượt nội dung miễn phí trong ngày. Để được nghe, xem, tải nội dung miễn phí không giới hạn số lượng, miễn cước data, vui lòng đăng nhập',
        'content_download' => 'Phí tải :CONTENT này là :PRICE đ. Quý khách có thật sự muốn tải không?',
        'content_play' => "Bạn có muốn nghe bài hát :NAME với giá :PRICE đ?",
        'content_download_request' => 'Qúy khách vui lòng đăng ký để được tải nội dung miễn phí hoặc tiếp tục tải nội dung này với giá :PRICE đ.',
        'confirm_unreg'=>'Bạn đang sử dụng gói cước {:PACKAGE} có thời hạn đến {:DATE}. Bạn có muốn hủy gói cước không?',
        'price'=>array(
            'show_price'=>'Cuoc DV Amusic: A1 - 2.000d/ngay (mien phi dang ky lan dau), A7 -  7.000d/tuan (mien phi dang ky lan dau). Chi tiet truy cap http://amusic.vn hoac goi 9090 (200d/phut). Tran trong cam on!',
        ),
        'sms.messageMT' => array(
            'error_syntax' => 'Xin loi, Quy khach vua nhap sai cu phap. De nghe xem tai bai hat va cac clip ca nhac HOT nhat hien nay soan DK Tengoi gui 9166 (Tengoi: A1 - goi ngay, A7 - goi tuan). De kiem tra goi cuoc, soan KT gui 9166. De biet gia, soan GIA gui 9166, de huy soan HUY Tengoi gui 9166. Truy cap http://amusic.vn hoac goi 9090 (200d/phut) de biet them chi tiet. Tran trong cam on!',
        ),
        'sms_tc'=>array(
            'sms_tc_am1'=>'Quy khach da tu choi nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A1 dich vu Amusic. De dang ky lai, vui long soan DK SMS A1 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'sms_tc_am7'=>'Quy khach da tu choi nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A7 dich vu Amusic. De dang ky lai, vui long soan DK SMS A7 gui 9166. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',

        ),
        'sms_dk'=>array(
            'sms_dk_a1'=>'Quy khach da dang ky nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A1 dich vu Amusic. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!',
            'sms_dk_a7'=>'Quy khach da dang ky nhan cac ban tin thong bao noi dung dinh ky cua goi cuoc A7 dich vu Amusic. Chi tiet lien he 9090 (200d/phut). Tran trong cam on!'
        ),

        'ctkm_sms'=>array(
            'subscribe_firstime'=>'Chuc mung, Quy khach da nhan duoc :POINT diem tich luy CTKM “NGHE NHAC HAY -  TRUNG NGAY HONDA LEAD”. Tu nay den het 29/11/2015, tiep tuc nghe xem noi dung tren Amusic de co co hoi nhan ngay 1 xe Honda Lead va nhung phan qua gia tri khac. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu. Chi tiet LH 9090 (200d/p). Chuc Quy khach may man!',
            'tich_luy_diem'=>'Diem tich luy CTKM “NGHE NHAC HAY -  TRUNG NGAY HONDA LEAD” cua Quy khach hien tai la: :POINT. Moi Quy khach truy cap http://amusic.vn de tiep tuc tham gia tich diem va co co hoi nhan ngay 1 xe Honda Lead va nhieu phan qua hap dan khac. Tra cuu diem thuong tai http://amusic.vn/ctkm/tracuu. Chi tiet LH 9090 (200d/p). Chuc Quy khach may man!',
        ),

    )
);
?>