<?php
include '../common.php';

if (!$user->checkAuth())
{	
	//if your not logged in you shouldn't be here
	//Send error message to the file uploader
	echo '<div class="alert alert-danger" id="returnMessage" role="alert">You are not logged in</div>';
	exit;
}

if(!$_GET['action']){
	//if your not logged in you shouldn't be here
	//Send error message to the file uploader
	echo "<div class='alert alert-danger' id='returnMessage' role='alert'>Couldn't upload the pictures please try again";
	exit;
}
else
{
	include PLUGIN_PATH . 'UploadHandler/UploadHandler.php';
	$uploader = new UploadHandler();
	switch($_GET['action'])
	{
		case 1:
			echo $uploader->FileUploader($_FILES['file']);
		break;
		case 2:
			if(isset($_SESSION['UPLOADED_PICTURES']))
			{
				foreach($_SESSION['UPLOADED_PICTURES'] as $k => $v)
				{
					if(file_exists(UPLOAD_TMP_PATH . '/' . $v))
					{
						if($_SESSION['SELL_pict_url'] == $v)
						{
							echo '
								<tr id="displayImages">
									<td>
										<img title="' . $v . '" width="120%" class="img-responsive img-thumbnail" src="' . $system->SETTINGS['siteurl'] . 'uploaded/temps/' . session_id() . '/' . $v . '">
									</td>
									<td>
										<br />
										<div align="center">
											<span><strong>' . $MSG['3500_1016031'] . '</strong><span><br />
											<button class="btn btn-danger" onclick="DeleteImage(\'' . $v . '\')"><i class="fa fa-trash" aria-hidden="true"></i> ' . $MSG['008'] . '</button>
										</div>
									</td>
								</tr>
							';
						}else{
							echo '
								<tr id="displayImages">
									<td>
										<img title="' . $v . '" width="120%" class="img-responsive img-thumbnail" src="' . $system->SETTINGS['siteurl'] . 'uploaded/temps/' . session_id() . '/' . $v . '">
									</td>
									<td>
										<br /><br />
										<div align="center">
											<button class="btn btn-danger" onclick="DeleteImage(\'' . $v . '\')"><i class="fa fa-trash" aria-hidden="true"></i> ' . $MSG['008'] . '</button>
											<button class="btn btn-success" onclick="setDefaultImage(\'' . $v . '\')"><i class="fa fa-check" aria-hidden="true"></i> ' . $MSG['3500_1015500'] . '</button>
										</div>
									</td>
								</tr>
							';
						}
					}else{
						echo '<tr id="displayImages"><tr>';
					}
				}
			}
		break;
		case 3:
			echo $uploader->SetDefaultImage($_POST['setDefaultImage']);
		break;
		case 4:
			echo $uploader->GetDefaultImage();
		break;
		case 5:
			$uploader->DeletePicture($_POST['PictureName']);
		break;
	}
}

