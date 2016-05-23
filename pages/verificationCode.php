<?php
/**
 * Created by PhpStorm.
 * User: catkint-pc
 * Date: 2016/5/23
 * Time: 20:22
 */
session_start();
class Authnum {
//ͼƬ���󡢿�ȡ��߶ȡ���֤�볤��
    private $im;
    private $im_width;
    private $im_height;
    private $len;
//����ַ�����y������ֵ�������ɫ
    private $randnum;
    private $y;
    private $randcolor;
//����ɫ�ĺ�������Ĭ����ǳ��ɫ
    public $red=238;
    public $green=238;
    public $blue=238;
    /**
     * ��ѡ���ã���֤�����͡����ŵ㡢�����ߡ�Y�����
     * ��Ϊ false ��ʾ������
     **/
//Ĭ���Ǵ�Сд���ֻ���ͣ�1 2 3 �ֱ��ʾ Сд����д��������
    public $ext_num_type='';
    public $ext_pixel = false; //���ŵ�
    public $ext_line = false; //������
    public $ext_rand_y= true; //Y�����
    function __construct ($len=4,$im_width='',$im_height=25) {
// ��֤�볤�ȡ�ͼƬ��ȡ��߶���ʵ������ʱ���������
        $this->len = $len; $im_width = $len * 15;
        $this->im_width = $im_width;
        $this->im_height= $im_height;
        $this->im = imagecreate($im_width,$im_height);
    }
// ����ͼƬ������ɫ��Ĭ����ǳ��ɫ����
    function set_bgcolor () {
        imagecolorallocate($this->im,$this->red,$this->green,$this->blue);
    }
// �������λ���������
    function get_randnum () {
        $an1 = 'abcdefghijklmnopqrstuvwxyz';
        $an2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $an3 = '0123456789';
        $randnum = null;
        if ($this->ext_num_type == '') $str = $an1.$an2.$an3;
        if ($this->ext_num_type == 1) $str = $an1;
        if ($this->ext_num_type == 2) $str = $an2;
        if ($this->ext_num_type == 3) $str = $an3;
        for ($i = 0; $i < $this->len; $i++) {
            $start = rand(1,strlen($str) - 1);
            $randnum .= substr($str,$start,1);
        }
        $this->randnum = $randnum;
        $_SESSION['verification'] = $this->randnum;
    }
// �����֤��ͼƬY��
    function get_y () {
        if ($this->ext_rand_y) $this->y = rand(5, $this->im_height/5);
        else $this->y = $this->im_height / 4 ;
    }
// ������ɫ
    function get_randcolor () {
        $this->randcolor = imagecolorallocate($this->im,rand(0,100),rand(0,150),rand(0,200));
    }
// ��Ӹ��ŵ�
    function set_ext_pixel () {
        if ($this->ext_pixel) {
            for($i = 0; $i < 100; $i++){
                $this->get_randcolor();
                imagesetpixel($this->im, rand()%100, rand()%100, $this->randcolor);
            }
        }
    }
// ��Ӹ�����
    function set_ext_line () {
        if ($this->ext_line) {
            for($j = 0; $j < 2; $j++){
                $rand_x = rand(2, $this->im_width);
                $rand_y = rand(2, $this->im_height);
                $rand_x2 = rand(2, $this->im_width);
                $rand_y2 = rand(2, $this->im_height);
                $this->get_randcolor();
                imageline($this->im, $rand_x, $rand_y, $rand_x2, $rand_y2, $this->randcolor);
            }
        }
    }
    /**������֤��ͼ��
     * ����������__construct������
     * ���û���������$this->set_bgcolor();��
     * ��ȡ����ַ�����$this->get_randnum ();��
     * ����д��ͼƬ�ϣ�imagestring������
     * ��Ӹ��ŵ�/�ߣ�$this->set_ext_line(); $this->set_ext_pixel();��
     * ���ͼƬ
     **/
    function create () {
        $this->set_bgcolor();
        $this->get_randnum ();
        for($i = 0; $i < $this->len; $i++){
            $font = rand(4,6);
            $x = $i/$this->len * $this->im_width + rand(1, $this->len);
            $this->get_y();
            $this->get_randcolor();
            imagestring($this->im, $font, $x, $this->y, substr($this->randnum, $i ,1), $this->randcolor);
        }
        $this->set_ext_line();
        $this->set_ext_pixel();
        header("content-type:image/png");
        imagepng($this->im);
        imagedestroy($this->im); //�ͷ�ͼ����Դ
    }
}//end class
/**ʹ����֤����ķ�����
 * $an = new Authnum(��֤�볤��,ͼƬ���,ͼƬ�߶�);
 * ʵ����ʱ����������Ĭ������λ��60*25�ߴ�ĳ�����֤��ͼƬ
 * ��ҳ������֤��ķ������Ա� $_SESSION[an] �Ƿ���� $_POST[��֤���ı���ID]
 * ��ѡ���ã�
 * 1.��֤�����ͣ�$an->ext_num_type=1; ֵΪ1��Сд���ͣ�2�Ǵ�д���ͣ�3����������
 * 2.���ŵ㣺$an->ext_pixel = false; ֵΪfalse��ʾ����Ӹ��ŵ�
 * 3.�����ߣ�$an->ext_line = false; ֵΪfalse��ʾ����Ӹ�����
 * 4.Y�������$an->ext_rand_y = false; ֵΪfalse��ʾ��֧��ͼƬY�����
 * 5.ͼƬ�������ı� $red $green $blue ������Ա������ֵ����
 **/
$an = new Authnum();
$an->ext_num_type='';
$an->ext_pixel = true; //���ŵ�
$an->ext_line = false; //������
$an->ext_rand_y= true; //Y�����
$an->green = 238;
$an->create();
?>