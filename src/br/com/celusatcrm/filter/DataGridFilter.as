/*
Copyright (c) 2007 DClick Desenvolvimento de Software LTDA

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

package br.com.celusatcrm.filter
{
	
import mx.collections.ArrayCollection;
import mx.collections.ICollectionView;
import mx.controls.DataGrid;

/**
 * The DataGridFilter works with DataGridColumnFilter to filter the itens in the rows.
 * 
 * <p>It's appropriate to use this class to perform the filter task, instead of the DataGridColumnFilter, 
 * because it has knowledge about all columns and all rows.</p>
 * 
 * @see DataGridColumnFilter
 * 
 */
public class DataGridFilter extends DataGrid 
{
	
	//--------------------------------------------------------------------------
    //
    //  Class methods
    //
    //--------------------------------------------------------------------------	

	/**
	 * 
	 * Filter the DataGrid content.
	 * @see #filterItensByColumns()
	 * 
	 */
	public function filter():void 
	{
		if (dataProvider is ICollectionView)
		{
			dataProvider.filterFunction = filterItensByColumns;
			dataProvider.refresh();
			verticalScrollPosition = 0;
		}
	}

	/**
	 * @private
	 * 
	 * This method is called by each DataGrid's row. If it returns 'true', the row will be displayed, 
	 * otherwise it won't.
	 * 
	 * It returns 'true' if the row is in accordance with all columns criteria. That's an important point. It might have 
	 * a criteria in one column, another criteria in other column, and so on. But it's necessary just one column criteria 
	 * "not ok" to return 'false', and so, doesn't display the row.
	 * 
	 * @param item It is a row
	 * 
	 * @return Returns <code>true</code> to displayed rows and <code>false</code> to hidden rows
	 * 
	 * @see DataGridColumnFilter
	 * 
	 */
	private function filterItensByColumns(item:Object):Boolean 
	{
		var displayItem:Boolean = true;
		for each (var column:Object in columns)
		{
			if (column is DataGridColumnFilter && column.hasFilter) 
			{
				displayItem = displayItem && column.filter(item);
			}
		}
		return displayItem;
	}

	/**
	 * 
	 * Clean all filters.
	 * 
	 */
	public function cleanFilters():void 
	{
		for each(var column:Object in columns)
		{
			if (column is DataGridColumnFilter) 
			{
				column.hasFilter = false;
			}
		}
		filter();		
	}

	/**
	 * 
	 * Filters the columns to return an array with no repeated item labels.
	 * 
	 * @param column The column whose the labels will be returned.
	 * 
	 * @return An ArrayCollection with no repeated item labels in a column.
	 * 
	 */
	public function getExclusiveItemLabels(column:DataGridColumnFilter):ArrayCollection 
	{
		var exclusiveItemLabels:ArrayCollection = new ArrayCollection();
		for each (var item:Object in dataProvider)
		{
			var itemLabel:String = column.getItemLabel(item);
			if (exclusiveItemLabels.contains(itemLabel) == false)
			{
				exclusiveItemLabels.addItem(itemLabel);
			}
		}
		return exclusiveItemLabels;
	}

}

}