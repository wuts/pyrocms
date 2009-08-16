<?php
class Forum_model extends Model
{
	var $category_table = 'categories';
	var $forum_table = 'forums';
	var $post_table = 'forum_posts';
		
	// --- Category Related Queries --- //
	function getCategories()
    {
		$this->db->from($this->category_table);	
		$query = $this->db->get();
		
		return $query->result();
	}
	
	
    function getCategory($category_id = 0)
    {
		$this->db->where('id', $category_id);
		$query = $this->db->get($this->category_table, 1);

		return $query->row();
    }
	
	// --- Forum Related Queries --- //
	function getForums($category_id = 0)
    {
		$this->category_id = ($category_id > 0) ? $category_id : $this->category_id;
		
		$this->db->from($this->forum_table);	
		$this->db->where('category_id', $this->category_id);
		
		$query = $this->db->get();
		
		return $query->result();
	}
		
	function getForum($forum_id = 0)
    {
		$this->db->where('id', $forum_id);
		$query = $this->db->get($this->forum_table, 1);

		return $query->row();
    }
	
}
?>