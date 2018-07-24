<!DOCTYPE html>
<html>
<head>
	<title>Email Template</title>
</head>
<body style="margin: 0;padding: 0;font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif' !important; background:#fff !important;">

	<table style="width:100%;border: none;border-spacing: 0; margin: 0; padding: 0; background:#fff !important; margin-top:10px;">
		<tbody>

			<tr style="width: 100%;height: 80px;border:none;border-bottom: 1px solid #e0d7d7;">
				<td style="border: none;vertical-align: middle;">
					<div style="width: 50%;text-align: center;float: left;"><a href="<?= SITE_URL;?>"><img src="<?= SITE_URL;?>assets/img/logo.png" alt="Logo" width="100" height="50"></a></div>
					<div style="width: 50%;float: left;text-align: center;">
						
						<a href="<?= SITE_URL;?>hot_price/" target="_blank" style="margin:10px; padding:8px; background:transparent; color:#333; border: 1px solid #FFA500;" onMouseOver="this.style.color='#fff', this.style.background='#FDC600'" onMouseOut="this.style.color='#333', this.style.background='transparent'"> Hot Price </a>
						<a href="<?= SITE_URL;?>auction/" target="_blank" style="margin:10px; padding:8px; background:transparent; color:#333;border: 1px solid #FFA500;" onMouseOver="this.style.color='#fff', this.style.background='#FDC600'" onMouseOut="this.style.color='#333', this.style.background='transparent'"> Auction </a>
						
					</div>
				</td>
			</tr>

			<tr>
				<td style="border: none;vertical-align: middle;padding: 35px 0 15px 0;">
					<div style="font-size:32px;font-weight:700;color: #4d4d4d;text-align: center;">Your bidding is done properly... !</div>
				</td>
			</tr>

			<tr>
				<td style="border: none;vertical-align: middle;">
					<div style="font-size:14px;text-align:center;font-weight:normal;color: #777777;line-height: 21px;">
						We wanted to let you know that , after completion of the auction, we will send <br/> you detailed information about the auction. You'll find short summery below :
					</div>
				</td>
			</tr>

			<tr>
				<td style="border: none;vertical-align: middle;">
					<center>
						<div style="width:100%;max-width:440px;font-weight:normal;font-size: 14px;line-height: 21px;color: #777777;text-align: left;border: 1px solid #e5e5e5; border-radius: 5px;padding: 12px 15px 15px;margin-top: 10px;margin-left: auto;margin-right: auto; display: inline-block;">
							<span style="font-size: 18px;font-weight: 700;padding: 5px 0; color: #4d4d4d;line-height: 1.3;">Bidding Details</span><br />
	                        Property Name : <?= $name;?>. <br />
	                        Last Bid Price : $ <?= number_format($last_bid);?> <br />
	                        Your Bid Price : <b>$ <?= number_format($bid);?> </b> <br />
						</div>
					</center>
				</td>
			</tr>

			<tr>
				<td style="border: none;vertical-align: middle; padding: 35px 0;">
					<center>
						<div>
							<a href="<?= SITE_URL;?>preview?view=<?= $url_property;?>" style="width:155px;background:#ff6f6f;text-decoration: none;font-weight:normal;font-size: 14px;line-height: 45px;color: #ffffff;text-align: center;border-radius: 5px;display: inline-block;font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif' !important;" onmouseOver="this.style.color='#333'" onmouseOut="this.style.color='#fff'">
								View Property
							</a>
						</div>
					</center>
				</td>
			</tr>

			<tr>
				<td style="border: none;vertical-align: top; margin-bottom:10px;" valign="top">
					<center style="margin:0 auto;">

						<div style="width: 244px;display: inline-block;font-weight:normal;font-size: 14px;line-height: 23px;color: #777777;text-align: left;border: 1px solid #e5e5e5; border-radius: 5px;padding: 12px 15px 15px; margin-right: 15px;">
							<span style="font-size: 15px;font-weight: 700;padding: 5px 0; color: #4d4d4d;line-height: 1.3;">Property Address</span><br />
                            <?= $address;?>
                        </div>

                        <div style="width: 287px;display: inline-block;font-weight:normal;font-size: 14px;line-height: 21px;color: #777777;text-align: left;border: 1px solid #e5e5e5; border-radius: 5px;padding: 12px 15px 15px;">
							<span style="font-size: 15px;font-weight: 700;padding: 5px 0; color: #4d4d4d;line-height: 1.3;">Start Date Of Bidding</span><br />
                                 <b><?= date("D m, Y", strtotime($bid_date))?> </b><br /><br />
                              <span style="font-size: 15px;font-weight: 700;padding: 5px 0; color: #4d4d4d;line-height: 1.3;">Last Date Of Bidding</span> <br />
                                <?= date("D m, Y", strtotime($last_bid_date))?>
                        </div>

					</center>
				</td>
			</tr>

			<tr>
				<td style="border: none;vertical-align: middle; ">
					<center>
						<div style="width: 100%; min-width:440px; margin-top:20px; display: inline-block;padding: 12px 15px 15px;font-size: 14px;color: #4d4d4d; border-top: 1px solid #e0d7d7;">
							 <?= $company_info;?>
						</div>
					</center>
				</td>
			</tr>

		</tbody>
	</table>


</body>
</html>