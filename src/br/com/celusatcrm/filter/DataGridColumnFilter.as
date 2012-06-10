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
	
import flash.events.Event;
import flash.events.KeyboardEvent;
import flash.events.MouseEvent;
import flash.ui.Keyboard;

import mx.controls.dataGridClasses.DataGridColumn;
import mx.core.Application;
import mx.core.ClassFactory;
import mx.core.FlexGlobals;
import mx.core.IFactory;
import mx.core.mx_internal;
import mx.managers.PopUpManager;

use namespace mx_internal;

/**
 * The DataGridColumnFilter works with DataGridFilter to filter itens in the rows.
 * 
 * <p>The filter control is on the DataGridFilter because it has knowledge off all rows and all columns. But
 * the DataGridFilter use this class to perform the filter task appropriately.</p>
 * 
 * <p>This class also is responsible to manage the PopUp filter UI. The popUp will be created unsing the
 * <code>filterRenderer</code> property.</p> 
 * 
 * @see DataGridFilter
 * @see HeaderFilterRenderer
 * @see DefaultFilterRenderer
 * 
 */
public class DataGridColumnFilter extends DataGridColumn 
{

	/**
     * Constructor.
     * 
     * Sets the default filter renderer to <code>DefaultFilterRenderer</code>.
     * 
     * @param columnName The name of the field in the data provider 
     * associated with the column, and the text for the header cell of this 
     * column.  This is equivalent to setting the <code>dataField</code>
     * and <code>headerText</code> properties.
     * 
     * @see DefaultFilterRenderer
     * 
     */
	public function DataGridColumnFilter(colName:String=null)
	{
		super();
		headerRenderer = new ClassFactory(HeaderFilterRenderer);
		filterRenderer = new ClassFactory(DefaultFilterRenderer);
	}
		
	
	//--------------------------------------------------------------------------
    //
    //  Variables
    //
    //--------------------------------------------------------------------------
	
	/**
     *  @private
     *  A reference to the popUp object
     */	
	private var popUpFilter:FilterRendererBase;
	
	
	
	//--------------------------------------------------------------------------
    //
    //  Class methods
    //
    //--------------------------------------------------------------------------	
	
	/**
	 * 
	 * Creates the PopUp filter UI. This method is called by the <code>HeaderFilterRenderer</code> class when the
	 * user clicks on the filter icon.
	 * 
	 * @param header The columns header whose the PopUp filter UI will be created. The PopUp filter UI will 
	 * be created using the <code>filterRenderer</code> property
	 * 
	 * @see HeaderFilterRenderer
	 * 
	 */	
	public function createPopUpFilter(header:HeaderFilterRenderer):void 
	{
		popUpFilter = FilterRendererBase(filterRenderer.newInstance());
		PopUpManager.addPopUp(popUpFilter, header.owner);
		
		popUpFilter.addEventListener(FilterRendererEvent.FILTER, filterHandler);
		popUpFilter.addEventListener(KeyboardEvent.KEY_UP, keyUpHandler);
		popUpFilter.data = getDataGridFilter().getExclusiveItemLabels(this);
		popUpFilter.header = header;
			
		FlexGlobals.topLevelApplication.application.addEventListener(MouseEvent.MOUSE_DOWN, applicationMouseDownHandler);
	}

	/**
	 * 
	 * Destroys the PopUp filter UI.
	 * 
	 */	
	public function destroyPopUpFilter():void
	{
		popUpFilter.removeEventListener(FilterRendererEvent.FILTER, filterHandler);
		popUpFilter.removeEventListener(KeyboardEvent.KEY_UP, keyUpHandler);
		
		PopUpManager.removePopUp(popUpFilter);
		
		FlexGlobals.topLevelApplication.application.removeEventListener(MouseEvent.MOUSE_DOWN, applicationMouseDownHandler);
	}

	/**
	 * 
	 * @private
	 * 
	 * It's a convenience method to return a typed DataGridFitler.
	 * 
	 * @return The dataGridFilter typed
	 * 
	 */	
	private function getDataGridFilter():DataGridFilter 
	{
		return DataGridFilter(owner);
	}

	/**
	 * 
	 * It masks this column to remove the filter and asks to the DataGridFilter to perform
	 * the filter task
	 * 
	 * @see DataGridFilter
	 * 
	 */
	public function cleanFilter():void 
	{
		hasFilter = false;
		getDataGridFilter().filter();
	}
	
	
	/**
	 * 
	 * This method will be called by the DataGridFilter for each row. It delegates the filter task to the 
	 * filter PopUp UI.
	 * 
	 * @param item The row
	 * @return <code>true</code> to display the row and <code>false</code> to hide the row
	 * 
	 */	
	public function filter(item:Object):Boolean 
	{
		return popUpFilter.onFilter(item, getItemLabel(item));
	}
	
	/**
	 * 
	 * Returns the item label for this column.
	 * 
	 * @param item The row
	 * @return The item label for this column.
	 * 
	 */	
	public function getItemLabel(item:Object):String 
	{
		if (dataField == null)
		{
			return labelFunction(item, dataField);
		}
		return item[dataField];
	}




	//--------------------------------------------------------------------------
    //
    //  handlers
    //
    //--------------------------------------------------------------------------

	/**
	 * 
	 * @private
	 * 
	 * This handler will be called by the PopUp filter UI when the user wants to perform
	 * the filter task. It will mark this column to filter and asks to the DataGridFilter 
	 * to perform the filter task.
	 * 
	 * @param event
	 * 
	 * @see DataGridFilter
	 * 
	 */	
	private function filterHandler(event:Event):void 
	{
		hasFilter = true;
		getDataGridFilter().filter();
		destroyPopUpFilter();
	}
	
	
	/**
	 * 
	 * @private
	 * 
	 * Destroys the PopUp filter UI when the user press the esc key.
	 * 
	 * @param event
	 * 
	 */	
	private function keyUpHandler(event:KeyboardEvent):void
	{
		if (event.keyCode == Keyboard.ESCAPE)
		{
			destroyPopUpFilter();
		}
	}
	
	/**
	 * 
	 * @private
	 * 
	 * This handler will be called when the user clicks on a place otherwise than 
	 * the PopUp filter UI.
	 * 
	 * @param event
	 * 
	 */
	private function applicationMouseDownHandler(event:MouseEvent):void 
	{
		destroyPopUpFilter();	
	}
	

	
	//--------------------------------------------------------------------------
    //
    //  Properties
    //
    //--------------------------------------------------------------------------
	
	/**
	 * @private
	 * 
	 * A filter flag for this column
	 *  
	 */	
	private var _hasFilter:Boolean = false;
	
	[Bindable]
	
	/**
	 * 
	 * A flag that determines if the row will be filtered by this column filter
	 * 
	 */	
	public function get hasFilter():Boolean 
	{
		return _hasFilter;
		
	}

	/**
	 * @private
	 */
	public function set hasFilter(value:Boolean):void 
	{
		_hasFilter = value;
	}
	
	
	/**
	* Storage for the filterRenderer reference
	*/	
	private var _filterRenderer:IFactory;
	
	[Bindable]
	
	/**
	 *
	 * The class used to create the PopUp filter UI 
	 * 
	 */	
	public function get filterRenderer():IFactory 
	{
		return _filterRenderer;
	}

	/**
	 * @private
	 */	
	public function set filterRenderer(value:IFactory):void 
	{
		_filterRenderer = value;
	}
	
}
	
}
