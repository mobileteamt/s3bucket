<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\S3\S3Client;

class ImageController extends CI_Controller {	
	protected $s3;
	protected $key = 'your-encryption-key';
	protected $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

    public function __construct() {
        parent::__construct();
		
		// Initialize S3 client
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'your-region',
            'credentials' => [
                'key'    => 'your-access-key',
                'secret' => 'your-secret-key',
            ],
        ]);
    }
	
	public function index() {
		$this->load->view('bucket-view');
	}

    public function upload() {
        // Handle image upload to S3
        // Remember to encrypt images if needed before uploading
		// Handle image upload
        $file = $_FILES['image'];

        // Encrypt the image data
		$encryptedImage = $this->encryptImage($file['tmp_name']);


        // Upload image to S3 bucket
        $result = $this->s3->putObject([
            'Bucket'     => 'your-bucket-name',
            'Key'        => 'images/' . $file['name'],
            'Body'       => $encryptedImage,
            'ContentType'=> $file['type']
        ]);
        
		// Load the view page
		$this->load->view('bucket-view');
    }
	
	
	private function encryptImage($imagePath) {
		// Read image file contents
		$imageData = file_get_contents($imagePath);

		// Used AES encryption 
		$encryptedData = openssl_encrypt($imageData, 'AES-256-CBC', $this->key, 0, $this->iv);
		return $encryptedData;
	}

    public function show($imageFileName) {
        // Fetch encrypted image from S3
        $result = $this->s3->getObject([
            'Bucket' => 'your-bucket-name',
            'Key'    => 'images/' . $imageFileName,
        ]);

        // Decrypt the image 
        $decryptedImage = $this->decryptImage($result['Body']);

        // Display the decrypted image
        header("Content-Type: image/jpeg");
        echo $decryptedImage;
    }

    private function decryptImage($encryptedImage) {
        
		// Used the OpenSSL to decrypt the image
		$decryptedImage = openssl_decrypt($encryptedImage, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
		return $decryptedImage;
    }
}
