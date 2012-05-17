<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

	function getCategories($id=false){
	global $ln;
		$categories = false;
		$sql = 'select * from categories, category_descriptions where categories.id=category_descriptions.categoryid and category_descriptions.lang="'.$ln.'"';
		if ($id){
			$sql.=' and categories.id="'.$id.'" limit 1';
		}		
		$res = DBselect ($sql);
		while ($row = DBfetch($res)){
			$categories[]=$row;
		}		
		return $categories;
	}	
	
	function saveCategory($category, $categoryid=false){
		if ($categoryid){
			$sql = 'update category_descriptions set ';
		} else {			
			$sql = 'insert into category_descriptions set ';
		}
		$f=false;
		foreach ($category as $key=>$val){
			if ($f){
				$sql.=', ';
			}
			$sql.=$key.'="'.$val.'"';
			$f=true;
		}
		if ($categoryid){
			$sql.= ' where categoryid="'.$categoryid.'"';			
		} else {
			$sql2 = 'insert into categories set enabled="1"';
			DBexecute($sql2);
			$r = DBfetch(DBselect('SELECT LAST_INSERT_ID()'));
			$categoryid = $r['LAST_INSERT_ID()'];
			$sql.= ', categoryid="'.$categoryid.'"';	
		}
		return DBexecute($sql);
	}
	
	function getCategoryById($id=false){
	global $ln;
		$category = false;
		$sql = 'select * from categories, category_descriptions where categories.id=category_descriptions.categoryid and category_descriptions.lang="'.$ln.'" and categories.id="'.$id.'" limit 1';
		
		$res = DBselect ($sql);
		while ($row = DBfetch($res)){
			$category=$row;
		}
		return $category;
	}	
	
	function getShopProductsGroupedByCategories(){
		$categories = false;
		$sql = 'select products.*, products_descriptions.title as producttitle, category_descriptions.title as categorytitle from products, categories, category_descriptions, products_descriptions where products.categoryid=categories.id and products.categoryid=category_descriptions.categoryid and products.status="1" and products.availible="1" and products_descriptions.productid=products.id';
		$res = DBselect($sql);
		while ($row = DBfetch($res)){
			if (!isset($categories[$row['categoryid']])){
				$categories[$row['categoryid']]=array(
				'title'=>$row['categorytitle'],
				'id'=>$row['categoryid'],
				'products'=>array());
			}
			$categories[$row['categoryid']]['products'][$row['id']]=array(
				'title'=>$row['producttitle'],
				'id'=>$row['id'],
				'module'=>'products/'.$row['id']
			);
		}
		return $categories;
	}
	
	function getProductsByCategory($categoryid){
	global $ln;
		$products = false;
		$sql = 'select * from products, products_descriptions where products.id=products_descriptions.productid and products.categoryid="'.$categoryid.'" and products_descriptions.lang="'.$ln.'" order by products.index asc';		
		$res = DBselect ($sql);
		while ($row = DBfetch($res)){		
			$row['mainpic']='blank.gif';
			$productid=$row['productid'];
			$sql = 'select * from images where productid="'.$productid.'"';		
			$rrr = DBselect($sql);
			while ($row2 = DBfetch($rrr)){
				$row['images'][]=$row2;
				if ($row2['main']=='1'){
					$row['mainpic']=$row2['file'];
				}
			}
			$products[]=$row;
		}
		return $products;		
	}
	
	function getAllProducts(){
	global $ln;
		$products = false;
		$sql = 'select * from products, products_descriptions where products.id=products_descriptions.productid and products_descriptions.lang="'.$ln.'" order by products.index asc';		
		$res = DBselect($sql);				
		while ($row = DBfetch($res)){
			$products[]=$row;
		}
		return $products;		
	}
	
	function getAllShopProducts(){
	global $ln;
		$products = false;
		$sql = 'select * from products, products_descriptions where products.id=products_descriptions.productid and products_descriptions.lang="'.$ln.'" and products.categoryid!="13" and availible="1" order by products.index asc';		
		$res = DBselect($sql);				
		while ($row = DBfetch($res)){
			$sql = 'select * from images where productid="'.$row['productid'].'"';		
			$rrr = DBselect($sql);
			$row['mainpic']=false;
			while ($row2 = DBfetch($rrr)){
				$row['images'][]=$row2;
				if (($row2['main']=='1')&&($row2['index']>0)){
					$row['mainpic']=$row2['file'];
				}
			}
			$products[]=$row;
		}
		return $products;		
	}
	
	
	function getProductById($productid){
	global $ln;
		$product = false;
		$sql = 'select * from products, products_descriptions where products.id=products_descriptions.productid and products_descriptions.lang="'.$ln.'" and products.id="'.$productid.'" limit 1';
		$res = DBselect ($sql);
		while ($row = DBfetch($res)){
			$product=$row;
		}
		$product['images']=array();
		$product['mainpic']=false;
		$sql = 'select * from images where productid="'.$productid.'"';		
		$res = DBselect($sql);
		while ($row = DBfetch($res)){			
			$product['images'][]=$row;
			if ($row['main']=='1'){
				$product['mainpic']=$row['file'];
			}
		}
		$product['sounds']=array();
		$sql = 'select * from sounds where productid="'.$productid.'"';
		$res = DBselect($sql);		
		while ($row = DBfetch($res)){			
			$product['sounds'][]=$row;			
		}					
		
		$product['reviews']=array();
		$sql = 'select * from reviews where productid="'.$productid.'"';
		$res = DBselect($sql);
		while ($row = DBfetch($res)){			
			$product['reviews'][]=$row;			
		}	
		
		$product['feedbacks']=array();
		$sql = 'select * from feedbacks where productid="'.$productid.'"';
		$res = DBselect($sql);
		while ($row = DBfetch($res)){			
			$product['feedbacks'][]=$row;			
		}	
		
		$product['features']=array();
		$sql = 'select * from products_features where productid="'.$productid.'"';
		$res = DBselect($sql);
		while ($row = DBfetch($res)){
			$product['features'][]=$row;
		}				
			
		return $product;	
	}
	
	function saveProduct($product, $productid=false){		
		if ($productid){
			$sql = 'update products';			
			
		} else {
			$sql = 'insert into products';	
				
		}
		
		if (isset($product['availible'])){			
			if ($product['availible']=='on'){
				$product['availible']='1';
			} else {
				$product['availible']='0';
			}
		} else {
			$product['availible']='0';
		}
		
		if (isset($product['showonmain'])){			
			if ($product['showonmain']=='on'){
				$product['showonmain']='1';
			} else {
				$product['showonmain']='0';
			}
		} else {
			$product['showonmain']='0';
		}
		
		
		$sql.= ' set price="'.$product['price'].'", categoryid="'.$product['categoryid'].'", availible="'.$product['availible'].'", showonmain="'.$product['showonmain'].'", products.index="'.$product['index'].'"';		


		
		if ($productid){
			$sql.= ' where id="'.$productid.'"';
		
		} 
		$result = DBexecute($sql);
		
		if ($productid){
			$sql2 = 'update products_descriptions'; 
		} else {
			$sql2 = 'insert into products_descriptions'; 	
		}

		$sql2.=' set description="'.addslashes($product['description']).'", title="'.addslashes($product['title']).'", long_description="'.addslashes($product['long_description']).'", specs="'.addslashes($product['specs']).'"';	
		if ($productid){
			$sql2.= ' where lang="en" and productid="'.$productid.'"';				
		} else {
			$r = DBfetch(DBselect('SELECT LAST_INSERT_ID()'));
			$sql2.= ', lang="'.$product['lang'].'", productid="'.$r['LAST_INSERT_ID()'].'"';
		}		
	
		//debug($sql2);
	
		DBexecute($sql2);		
		
		return $result;
	}
	
	function eraseCategory($categoryid){
		$sql = 'delete from categories where id="'.$categoryid.'" limit 1';
		DBexecute($sql);
		$sql = 'delete from category_descriptions where id="'.$categoryid.'" limit 1';
		DBexecute($sql);		
	}
	
	function eraseProduct($productid){
		$sql = 'delete from products where id="'.$productid.'" limit 1';
		DBexecute($sql);
		$sql = 'delete from products_descriptions where id="'.$productid.'" limit 1';
		DBexecute($sql);		
	}
	
	function getProductFeeedbacks($pid=null){
	global $ln;
		$sql = 'select feedbacks.*, products.*, products_descriptions.* from feedbacks, products, products_descriptions where feedbacks.productid=products.id and feedbacks.active="1" and products_descriptions.lang="'.$ln.'" and products_descriptions.productid=feedbacks.productid order by products.index';
		if ($pid){
			$sql.=' and feedbacks.productid="'.$pid.'"';
		}
		$res = DBselect($sql);
		$feedbacks = false;
		if ($res){
			while ($row = DBfetch($res)){								
				if (!isset($feedbacks[$row['productid']])){
					$feedbacks[$row['productid']]=array('title'=>$row['title'], 'productid'=>$row['productid'], 'description'=>$row['description'], 'long_description'=>$row['long_description'], 'status'=>$row['status'], 'image'=>$row['image']);		
					$sql = 'select * from images where productid="'.$row['productid'].'"';		
					$rrr = DBselect($sql);
					while ($row2 = DBfetch($rrr)){
						$feedbacks[$row['productid']]['images'][]=$row2;
						if (($row2['main']=='1')&&($row2['index']>0)){
							$feedbacks[$row['productid']]['mainpic']=$row2['file'];
						}
					}					
				}
				$feedbacks[$row['productid']]['feedbacks'][]=array('user'=>$row['user'], 'text'=>$row['text']);				
			}
		}
		return $feedbacks;
	}
	
	function getShopProductsIds(){
	global $ln;
		$sql = '
		select 
			products.id, products_descriptions.title 
		from 
			products, products_descriptions, category_descriptions 
		where 
			products.categoryid=category_descriptions.categoryid 
			and category_descriptions.lang="en" 
			and category_descriptions.title="Shop" 
			and products_descriptions.lang="'.$ln.'" 
			and products_descriptions.productid=products.id
		order by
			products.index';
			
		$res = DBSelect($sql);
		$result = array();		
		if ($res){
			while ($row = DBFetch($res)){
				$result[]=array('module'=>'products/'.$row['id'], 'title'=>$row['title'], 'productid'=>$row['id']);			
			}
		}		
		return $result;
	}
	
?>