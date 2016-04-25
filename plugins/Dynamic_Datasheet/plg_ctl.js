// db.prep()
var plugin_data = {
    "customer": [
        {
            "customer_id": "01",
            "customer_name": "Qualcomm"
        },
        {
            "customer_id": "02",
            "customer_name": "Telnet"
        },
        {
            "customer_id": "03",
            "customer_name": "Mantra"
        },
        {
            "customer_id": "04",
            "customer_name": "Tenet"
        },
        {
            "customer_id": "05",
            "customer_name": "Quaridge"
        },
        {
            "customer_id": "06",
            "customer_name": "Antrope"
        }
    ],
    "assembly": [
        {   
            "assembly_id": "01",
            "customer_id": "01",
            "assembly_number": "cust01.ab01",
            "revision": "ab01.rev01"
        },
        {   
            "assembly_id": "02",
            "customer_id": "02",
            "assembly_number": "cust02.ab02",
            "revision": "ab02.rev01"
        },
        {   
            "assembly_id": "03",
            "customer_id": "03",
            "assembly_number": "cust03.ab03",
            "revision": "ab03.rev01"
        },
        {   
            "assembly_id": "04",
            "customer_id": "01",
            "assembly_number": "cust01.ab04",
            "revision": "ab04.rev01"
        },
        {   
            "assembly_id": "05",
            "customer_id": "01",
            "assembly_number": "cust03.ab05",
            "revision": [
                {
                    "01": "ab05.rev01"
                },
                {
                    "02": "ab05.rev01"
                },
                {
                    "03": "ab05.rev01"
                }
            ]
        },
        {   
            "assembly_id": "06",
            "customer_id": "04",
            "assembly_number": "cust04.ab06",
            "revision": "ab06.rev01"
        },
        {   
            "assembly_id": "07",
            "customer_id": "04",
            "assembly_number": "cust04.ab06",
            "revision": "ab06.rev02"
        },
        {   
            "assembly_id": "08",
            "customer_id": "04",
            "assembly_number": "cust04.ab06",
            "revision": "ab06.rev03"
        },
        {   
            "assembly_id": "09",
            "customer_id": "05",
            "assembly_number": "cust05.ab09",
            "revision": "ab09.rev01"
        },
        {   
            "assembly_id": "10",
            "customer_id": "05",
            "assembly_number": "cust05.ab10",
            "revision": "ab10.rev01"
        },
        {   
            "assembly_id": "11",
            "customer_id": "06",
            "assembly_number": "cust06.ab09",
            "revision": "ab09.rev01"
        },
        {   
            "assembly_id": "12",
            "customer_id": "06",
            "assembly_number": "cust06.ab12",
            "revision": "ab12.rev03"
        }
    ],
    "timeline": [
        {
            "assembly_id": "01",
            "date_received": "20150118-14-23",
            "date_completed": "20150127-09-12",
            "pcb_date": "20150120-09-50",
            "schedule": "20150122-10-20"
        },
        {
            "assembly_id": "02",
            "date_received": "20150218-14-23",
            "date_completed": "20150227-09-12",
            "pcb_date": "20150220-09-50",
            "schedule": "20150222-10-20"
        },
        {
            "assembly_id": "03",
            "date_received": "20150318-14-23",
            "date_completed": "20150327-09-12",
            "pcb_date": "20150320-09-50",
            "schedule": "20150322-10-20"
        },
        {
            "assembly_id": "04",
            "date_received": "20150418-14-23",
            "date_completed": "20150427-09-12",
            "pcb_date": "20150420-09-50",
            "schedule": "20150422-10-20"
        },
        {
            "assembly_id": "05",
            "date_received": "20150518-14-23",
            "date_completed": "20150527-09-12",
            "pcb_date": "20150520-09-50",
            "schedule": "20150522-10-20"
        },
        {
            "assembly_id": "06",
            "date_received": "20150618-14-23",
            "date_completed": "20150627-09-12",
            "pcb_date": "20150620-09-50",
            "schedule": "20150622-10-20"
        },
        {
            "assembly_id": "07",
            "date_received": "20150718-14-23",
            "date_completed": "20150727-09-12",
            "pcb_date": "20150720-09-50",
            "schedule": "20150722-10-20"
        },
        {
            "assembly_id": "08",
            "date_received": "20150818-14-23",
            "date_completed": "20150827-09-12",
            "pcb_date": "20150820-09-50",
            "schedule": "20150822-10-20"
        },
        {
            "assembly_id": "09",
            "date_received": "20150918-14-23",
            "date_completed": "20150927-09-12",
            "pcb_date": "20150920-09-50",
            "schedule": "20150922-10-20"
        },
        {
            "assembly_id": "10",
            "date_received": "20151018-14-23",
            "date_completed": "20151027-10-12",
            "pcb_date": "20151020-10-50",
            "schedule": "20151022-11-20"
        },
        {
            "assembly_id": "11",
            "date_received": "20151118-14-23",
            "date_completed": "20151127-11-12",
            "pcb_date": "20151120-11-50",
            "schedule": "20151122-11-20"
        },
        {
            "assembly_id": "12",
            "date_received": "20151218-14-23",
            "date_completed": "20151227-12-12",
            "pcb_date": "20151220-12-50",
            "schedule": "20151222-12-20"
        }
    ]
};

// debuggers & err handlers
var ctl = {
    ls: function( _ ){
        var s = "";
        var ft = true;
        for( var p in _){
          if (ft) {
            ft = false;
            s += p + ": " + _[p];
          }
          else s += ", " + p + ": " + _[p];
        }
        return s;
    }
};

var errHandler = function(cb){
    try {  cb  }
    catch (e) {
        if (e instanceof RangeError){
            console.log(e.message);
        }
    }
};

// helpers
var extend = function(out) {
  out = out || {};
  for (var i = 1; i < arguments.length; i++) {
    if (!arguments[i])
      continue;
    
    for (var key in arguments[i]) {
      if (arguments[i].hasOwnProperty(key))
            out[out.length+key] = arguments[i][key];
    }
  }
  return out;
};

/* architecture of classes: customer, assembly, timeline
function Customer(name,id)
function Assembly(name,id) extends Customer() {
    // Call the parent constructor to inherit from the parent class.
    Customer.call(this);
}
function Timeline(name,id) extends Assembly() {
    // Call the parent constructor to inherit from the parent class.
    Customer.call(this);
}
*/

// classes modeling, chain of classes & accessors.
function pluginData(){
// function pluginData(name){
    // this.name = name;
    this.fn = {
        ls_customer: function(){
            return plugin_data.customer;
            // return plugin_data.customer.valueOf(); // favored for listing
        },
        customer: function(x){
          if (typeof x === 'object') {
            x = x || {};
            plugin_data.customer = plugin_data.customer.concat(x);
            return plugin_data.customer;
          } else
            return plugin_data.customer[x];
        },
        del_customer: function(x, y){
            y = y || 1;
            return plugin_data.customer.splice(x,y);
        },
        assembly: function(x){
          if (typeof x === 'object') {
            plugin_data.assembly = plugin_data.assembly.concat(x);
            return plugin_data.assembly;
          } else
            return plugin_data.assembly[x];
        },
        del_assembly: function(x, y){
            y = y || 1;
            return plugin_data.assembly.splice(x,y);
        },
        timeline: function(x){
          if (typeof x === 'object') {
            plugin_data.timeline = plugin_data.timeline.concat(x);
            return plugin_data.timeline;
          } else
            return plugin_data.timeline[x];
        },
        del_timeline: function(x, y){
            y = y || 1;
            return plugin_data.timeline.splice(x,y);
        }
    };
}

// append custom fn to an obj
var plg_data = {
    customer: ["c1", "c2", "c3"],
    assembly: ["a1", "a2", "a3"],
    timeline: ["tl1", "tl2", "tl3"]
};

plg_data.listCustomer = function(){
    return this.customer.valueOf();
};

// # Prototype - add prop and method
pluginData.prototype.sound = "Grrrrr";
pluginData.prototype.makeSound = function() {
  return " says " + this.sound;
};

// # TESTING
var Asiakas1 = new pluginData();
// test class models
// console.log(Asiakas1.fn.customer(1));
console.log(Asiakas1.fn.assembly(1));
Asiakas1.fn.customer(
    [
        {
            "customer_id": "07",
            "customer_name": "Quarantie"
        },
        {
            "customer_id": "08",
            "customer_name": "Antelope"
        }
    ]
);

console.log(Asiakas1.fn.ls_customer());
// test prototype
console.log(Asiakas1.makeSound());

// test debuggers
plg_data.getCustomer = (function(){
    return function(i){
        if (i > this.customer.length)  {
            throw new RangeError( "::index out of scope (0," + this.customer.length + ")");
        } else {
            return this.customer[i];
        }
    };
})();

console.log(plg_data.listCustomer());
console.log(plg_data.getCustomer(2));
Asiakas1.fn.del_customer(1);
console.log(Asiakas1.fn.ls_customer());

console.log(ctl.ls(plg_data));

// errHandler(console.log(plg_data.getCustomer(5)));
/*try {
    console.log(plg_data.getCustomer(5));
} catch (e) {
    if (e instanceof RangeError){
        console.log(e.message);
    }
}*/

// console.log(plg_data.getCustomer(5));
// plg_data.errHandler(plg_data.getCustomer(2));
// var s = plg_data.errHandler(plg_data.getCustomer(5));

// fn accessing!?!s
var obj = {
  // anonymous
  someMethod: function myFunc() {},
  untitleMethod: function (){}
};

obj.someMethod.name = 'someMethod';
console.log(obj.someMethod.name, obj.untitleMethod.name); // my Func && empty string

var Circle = function (r) {
    this._radius  = r;
};
 
Circle.prototype = {
    set r(r) { this._radius = r; },
    get r() { return this._radius; },
    get area() { return Math.PI * (this._radius * this._radius); }
};
var circ = new Circle(10);
 
circ.r = 15;
 
console.log("A circle with radius " + circ.r + " has an area of " + circ.area.toFixed(2) + "<br />");

// ECMA 5
var addStuff = {
    sum: function (num1, num2){
        return num1 + num2;
    }
};
console.log(addStuff.sum(1,2));