<?php
namespace LearnPSQL;

/**
 *  Output Table
 */
class OutputTable 
{
	/**
     * Fetched rows
     * @var array
     */
	private $rows = [];

	/**
     * Columns names from fetched rows
     * @var array
     */
	private $columns = [];

	/**
     * Set columns from fetched data
     * @param array $data
     * @return void
     */
	function setColumns($data){
		$this->columns = $data;
	}

	/**
     * Set rows from fetched data 
     * @param array $data
     * @return void
     */
	function setRows($data){
		$this->rows = $data;
	}

	/**
     * prepare Table for output
     * @return $string
     */
	function outputData(){
		$output = "<table cellpadding=2 cellspacing=2><tr>";
		foreach ($this->columns as $key => $value) { $output .= "<th>{$value}</th>"; }
		$output .= "</tr>";
		foreach ($this->rows as $i => $row) {
			$output .= "<tr>";
			foreach ($this->columns as $column) { $output .= "<td style=\"border:1px solid #ccc\">{$row[$column]}</td>"; }
			$output .= "</tr>";
		}
		$output .= "</table>";
		return $output;
	}
}