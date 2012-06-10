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
	
import flash.events.MouseEvent;
import flash.geom.Point;

import mx.containers.Box;
import mx.controls.DataGrid;
import mx.core.Application;
import mx.core.IFactory;
import mx.managers.PopUpManager;

[Event("filter", FilterRendererEvent)]


/**
 * The base class for PopUp filter UI Renderer
 * 
 * <p>This class implements the IFactory interface because it's necessary to the DataGridColumn class create the
 * filter PopUp UI. It also defines an abastract method <code>onFilter</code> whose the child classes must implement.</p> 
 * 
 * @see DataGridColumnFilter
 * 
 */
public class FilterRendererBase extends Box implements IFactory 
{

	/**
     * Constructor.
     * 
     * Defines the default look and feel.
     * 
     */
	public function FilterRendererBase()
	{
		super();
		setStyle("borderStyle", "inset");
		setStyle("backgroundColor", "#FFFFFF");
		setStyle("dropShadowEnabled", true);
		setStyle("paddingTop", 2);
		setStyle("paddingBottom", 5);
		setStyle("paddingLeft", 5);
		setStyle("paddingRight", 2);
		setStyle("verticalGap",0);
	}
	
	
	//--------------------------------------------------------------------------
    //
    //  Class Methods
    //
    //--------------------------------------------------------------------------
	
	/**
	 * 
	 * @return A new FilterRendererBase instance
	 * 
	 */			
	public function newInstance():* 
	{
		return new FilterRendererBase();
	}
	
	/**
	 * 
	 * This method should be called by the concrete renderer classes.
	 * 
	 */	
	public function filter():void 
	{
		dispatchEvent(new FilterRendererEvent(FilterRendererEvent.FILTER));
	}
	
	/**
	 * 
	 * This method will be called by the DataGridColumn class to filter the itens.
	 * 
	 * This is an abstract method that should be implemented by the child classes.
	 * 
	 * @param item The entire row to be filtered
	 * @param itemLabelField The item label for one column
	 * @return <code>true</code> to display and <code>false</code> to hide
	 * 
	 */	
	public function onFilter(item:Object, itemLabelField:String):Boolean 
	{
		throw new Error("The overriden method '" + className + ".onFilter' is missing");
		return true;
	}
	
	
	/**
	 * 
	 * Defines the PopUp filter Interface position.
	 * 
	 * @param unscaledWidth
	 * @param unscaledHeight
	 * 
	 */	
	override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void
	{
		super.updateDisplayList(unscaledWidth, unscaledHeight);
		if (header)
		{
			var point:Point = header.owner.localToGlobal(new Point(header.x, header.y));
			var newX:int = point.x + 7;
			var newY:int = point.y + DataGrid(header.owner).headerHeight + 5;
			move(newX, newY);
		}
	}



	//--------------------------------------------------------------------------
    //
    //  Properties
    //
    //--------------------------------------------------------------------------
	
	/**
	* Storage for the header filter renderer
	*/	
	private var _header:HeaderFilterRenderer;
	
	/**
	 * 
	 * A referece to the DataGrid header whose this PopUp belongs. It will be used by updateDisplayList to position 
	 * the PopUp filter UI
	 * 
	 */
	public function get header():HeaderFilterRenderer
	{
		return _header;
	}
	
	/**
	 * @private
	 */	
	public function set header(value:HeaderFilterRenderer):void
	{
		_header = value;
	}
	
}

}