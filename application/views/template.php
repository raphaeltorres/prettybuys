<?php 
$this->parser->parse('header.tpl',$data,'','',TRUE); //last parameter is for root path
$this->parser->parse($mainContent,$data);
$this->parser->parse('footer.tpl', $data,'','',TRUE); //last parameter is for root path
?>