<?php

namespace App\Http\Controllers\Frontend;

use App\Api\Agentapi;
use App\Api\Propertyapi;
use App\Models\Enquiry;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PropertyImages;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {

        $path = Utils();
        $agentimage = AgentImage();
        $data = new Propertyapi();
        $data_lists = $data->property();

        $data = new Agentapi();
        $agentapi = $data->agentapi();

        $agents = $agentapi['data'];

        //16-10-2022
        $defaultimage = ['avatar-photo.png'];
        $allFeaturedProperty = DB::table('property')->select(
            'property.id',
            'property.price_asked',
            'property.property_name'
        ,
            'property.property_headline',
            'property.property_description',
            'property.product_category_id',
            'property.street_name',
            'property.property_building_name',
            'property.land_area',
            'property.no_bedrooms',
            'property.no_toilets',
            'product_category.product_category_name'
        ,
            'property.slug',
            'property_images.images_video',
            'property.building_area'
        )
            ->join('product_category', 'product_category.product_category_id', 'property.product_category_id')
            ->join('property_images', 'property_images.property_id', '=', 'property.id')
            ->where('property_images.type', 'Image')
            ->where('property.status', 'Open')

            ->where('property_images.isDefault', 1)
            ->orderBy('property.created_at', 'DESC')
            ->get();


        // $datas_details=$data_lists['data']['productdata'];

        $imagedata = $data_lists['data']['images'];
        $propertyfeatured = DB::table('property')->select(
            'property.id',
            'property.price_asked',
            'property.property_name'
        ,
            'property.property_headline',
            'property.property_description',
            'property.product_category_id',
            'property.street_name',
            'property.property_building_name',
            'property.land_area',
            'property.no_bedrooms',
            'property.no_toilets',
            'product_category.product_category_name'
        ,
            'property.slug',
            'property_images.images_video',
            'property.building_area'
        )
            ->join('product_category', 'product_category.product_category_id', 'property.product_category_id')
            ->join('property_images', 'property_images.property_id', '=', 'property.id')
            ->where('property_images.type', 'Image')

            ->where('isFeatured', true)
            ->where('property_images.isDefault', 1)
            ->orderBy('property.created_at', 'DESC')
            ->get();

        //  $datas=Property::with('ProductCategory','Province','PropertyImages','PropertyType')->paginate(2);
        $town = Town::where('town_status', 'active')->get();
        $rentsale = DB::table('product_category')->where('product_category_status', 'Active')->limit(2)->get();
        $propertytypes = PropertyType::where('property_type_status', 'Active')->get();

        return view('Frontend.home', compact('defaultimage', 'allFeaturedProperty', 'rentsale', 'propertytypes', 'town', 'agentimage', 'imagedata', 'propertyfeatured', 'path', 'agents'));
    }

    public function normalsearch(Request $request)
    {


        $path = Utils();


        $datas = Property::with('ProductCategory', 'Province', 'PropertyImages', 'PropertyType')

            ->join('property_images', 'property_images.property_id', '=', 'property.id')
            ->where('property.product_category_id', $request->cpt)

            ->where('property_images.isDefault', true);

        if ($request->location) {
            $datas = $datas->join('town', 'town.town_id', '=', 'property.town_id')
                ->where('town.town_name', $request->location);

        }


        if ($request->amenities_id) {

            $datas = $datas->join('property_amenities', 'property_amenities.property_id', '=', 'property.id')
                ->whereIn('property_amenities.amenities_id', $request->amenities_id);

        }

        if ($request->propertytype) {
            $datas = $datas->where('property_type_id', $request->propertytype);
        }
        if ($request->nobathrooms) {
            //            dd($request->nobathrooms);
            $datas = $datas->where('property.no_toilets', 5);
        }
        if ($request->nobedrooms == 1) {
            $datas = $datas->where('no_bedrooms', 1);
        }
        if ($request->nobedrooms == 2) {
            $datas = $datas->where('no_bedrooms', 2);
        }
        if ($request->nobedrooms == 3) {
            $datas = $datas->where('no_bedrooms', 3);
        }
        if ($request->nobedrooms == 4) {
            $datas = $datas->where('no_bedrooms', 4);
        }
        if ($request->nobedrooms == 5) {
            $datas = $datas->where('no_bedrooms', 5);
        }
        if ($request->nobedrooms == 6) {
            $datas = $datas->where('no_bedrooms', '>', 6);
        }
        if ($request->singleprice) {
            if ($request->singleprice == 1) {
                $datas = $datas->whereBetween('price_asked', [0, 10000]);
            } elseif ($request->singleprice == 2) {
                $datas = $datas->whereBetween('price_asked', [10000, 15000]);
            } elseif ($request->singleprice == 3) {
                $datas = $datas->whereBetween('price_asked', [12000, 25000]);
            } elseif ($request->singleprice == 4) {
                $datas = $datas->whereBetween('price_asked', [30000, 35001]);
            } elseif ($request->singleprice == 5) {
                $datas = $datas->whereBetween('price_asked', [40000, 45001]);
            } elseif ($request->singleprice == 6) {
                $datas = $datas->whereBetween('price_asked', [50000, 55001]);
            } elseif ($request->singleprice == 7) {
                $datas = $datas->whereBetween('price_asked', [60000, 65001]);
            }


        }
        $datas = $datas->get();


        $town = Town::where('town_status', 'active')->get();
        $propertytypes = PropertyType::where('property_type_status', 'Active')->get();
        $fetch = $request;
        //this above variable is wrong should be changed
        return view('Frontend.newpropertylist', compact('fetch', 'datas', 'town', 'propertytypes', 'path'));

    }




    public function propertylist(Request $request)
    {
        $town = Town::where('town_status', 'active')->get();
        $propertytypes = PropertyType::where('property_type_status', 'Active')->get();
        return view('Frontend.propertylist', compact('town', 'propertytypes'));
    }
    //property-list function
    public function propertyfilter(Request $request)
    {
        $path = Utils();
        // $data = Property::with('ProductCategory','Province','PropertyImages','PropertyType','PropertyAmenities')
        //     ->join('property_images','property_images.property_id','=','property.id')
        //     ->join('users','users.user_id','=','property.user_id')
        //     ->where('type','Image')->where('isDefault',true);
        $data = DB::table("property")
            ->leftjoin('property_images', 'property_images.property_id', '=', 'property.id')
            ->join('user_details', 'user_details.user_id', 'property.agent_id')
            ->join('product_category', 'product_category.product_category_id', 'property.product_category_id')
            ->join('users', 'users.user_id', 'property.agent_id')
            ->select(
                'property_images.images_video',
                'property.slug',
                'property.property_headline',
                'property.price_asked',
                'property.no_bedrooms'
            ,
                'property.no_toilets',
                'property.land_area',
                'property.street_name',
                'product_category.product_category_name',
                'users.full_name'
            ,
                'user_details.phone_1'
            )
            ->where('property_images.type', 'Image')->where('isDefault', true);

        //showing wrong resultss
        if ($request->amenities_id) {

            $data = $data
                ->join('property_amenities', 'property_amenities.property_id', '=', 'property.id')
                ->whereIn('property_amenities.amenities_id', [implode(', ', $request->amenities_id)]);


        }
        if ($request->product_category_name) {
            $data = $data->join('product_category', 'product_category.product_category_id', '=', 'property.product_category_id')
                ->where('product_category.product_category_name', $request->product_category_name);

        }

        if ($request->ptype) {
            $data = $data->where('property_type_id', $request->ptype);
        }
        if ($request->towncity) {
            $data = $data
                ->join('town', 'town.town_id', '=', 'property.town_id')
                ->where('town.town_name', $request->towncity);
        }

        if ($request->bed == 1) {
            $data = $data->where('no_bedrooms', 1);
        }
        if ($request->bed == 2) {
            $data = $data->where('no_bedrooms', 2);
        }
        if ($request->bed == 3) {
            $data = $data->where('no_bedrooms', 3);
        }
        if ($request->bed == 4) {
            $data = $data->where('no_bedrooms', 4);
        }
        if ($request->bed == 5) {
            $data = $data->where('no_bedrooms', 5);
        }
        if ($request->bed == 6) {
            $data = $data->where('no_bedrooms', '>', 6);
        }

        if ($request->nobathrooms) {
            $data = $data->where('no_toilets', $request->nobathrooms);
        }



        if ($request->prices) {
            if ($request->prices == 1) {
                $data = $data->whereBetween('price_asked', [0, 10000]);
            } elseif ($request->prices == 2) {
                $data = $data->whereBetween('price_asked', [10000, 15000]);
            } elseif ($request->prices == 3) {
                $data = $data->whereBetween('price_asked', [12000, 25000]);
            } elseif ($request->prices == 4) {
                $data = $data->whereBetween('price_asked', [30000, 35001]);
            } elseif ($request->prices == 5) {
                $data = $data->whereBetween('price_asked', [40000, 45001]);
            } elseif ($request->prices == 6) {
                $data = $data->whereBetween('price_asked', [50000, 55001]);
            } elseif ($request->prices == 7) {
                $data = $data->whereBetween('price_asked', [60000, 65001]);
            }


        }


        $data = $data->paginate(4);

        $html = '';
        if (count($data) > 0) {
            $html = '    <div class="row justify-content-center">
               <div class="col-lg-12 col-md-12">
                  <div class="item-shorting-box">
                     <div class="item-shorting clearfix">
                        <div class="left-column pull-left"><h4 class="m-0" >Found <span id="">' . $request->page . ' - </span> ' . count($data) . ' of ' . $data->total() . ' Results</h4></div>
                     </div>

                  </div>
               </div>
            </div>';
            foreach ($data as $property) {


                $html .= '

               <div class="col-lg-12 col-md-12">
                  <div class="property-listing property-1">

                     <div class="listing-img-wrapper">
                        <a href="">
                           <img src="' . $path . $property->images_video . '" class="img-fluid mx-auto" alt="" />
                        </a>
                     </div>

                     <div class="listing-content">

                        <div class="listing-detail-wrapper-box">
                           <div class="listing-detail-wrapper">
                              <div class="listing-short-detail">
                                 <h4 class="listing-name"><a href="' . route('single-property', $property->slug) . ' " >' . $property->property_headline . '</a></h4>
                                 <div class="fr-can-rating">
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="reviews_text">(42 Reviews)</span>
                                 </div>
                                 <span class="prt-types sale">' . $property->product_category_name . '</span>
                                 <span class="">' . $property->phone_1 . '</span>
                              </div>
                              <div class="list-price">
                                 <h6 class="listing-card-info-price">$' . $property->price_asked . '</h6>
                              </div>
                           </div>
                        </div>

                        <div class="price-features-wrapper">
                           <div class="list-fx-features">
                              <div class="listing-card-info-icon">
                                 <div class="inc-fleat-icon"><img src="' . url('/assets/frontend/img/bed.svg') . '" width="13" alt="" /></div>' . $property->no_bedrooms . ' Beds
                              </div>
                              <div class="listing-card-info-icon">
                                 <div class="inc-fleat-icon"><img src="' . url('/assets/frontend/img/bathtub.svg') . '" width="13" alt="" /></div>' . $property->no_toilets . ' Bath
                              </div>
                              <div class="listing-card-info-icon">
                                 <div class="inc-fleat-icon"><img src="' . url('/assets/frontend/img/move.svg') . '" width="13" alt="" /></div>' . $property->land_area . ' sqft
                              </div>
                           </div>
                        </div>

                        <div class="listing-footer-wrapper">
                           <div class="listing-locate">
                              <span class="listing-location"><i class="ti-location-pin"></i>' . $property->street_name . '&nbsp &nbspAgent:- ' . $property->full_name . '</span>
                           </div>
                           <div class="listing-detail-btn">
                              <a href="' . route('single-property', $property->slug) . '" class="more-btn">View</a>
                           </div>
                        </div>

                     </div>

                  </div>
               </div>';

            }
            return response()->json(['data' => $data, 'html' => $html, 'pagination' => (string) $data->links('components.custompagination')]);
        } else {
            $html .= '<h1 style="margin-top: 272px">No Data Found....</h1>';
        }
        return response()->json(['html' => $html, 'pagination' => '']);
    }


    public function getsearchfilter(Request $request)
    {


        $path = Utils();


        // $datas=Property::with('ProductCategory','Province','PropertyImages','PropertyType');
        $datas = DB::table("property")

            ->join('user_details', 'user_details.user_id', 'property.agent_id')
            ->join('product_category', 'product_category.product_category_id', 'property.product_category_id')
            ->join('users', 'users.user_id', 'property.agent_id')
            ->select(
                'property_images.images_video',
                'property.slug',
                'property.property_headline',
                'property.price_asked',
                'property.no_bedrooms'
            ,
                'property.no_toilets',
                'property.land_area',
                'property.street_name',
                'product_category.product_category_name',
                'users.full_name'
            ,
                'user_details.phone_1'
            )
            ->where('property_images.type', 'Image')->where('isDefault', true);


        if ($request->cpt) {
            $datas = $datas->join('property_images', 'property_images.property_id', '=', 'property.id')
                ->where('property.product_category_id', $request->cpt)
                ->where('property_images.isDefault', true);
        }


        if ($request->location) {
            $datas = $datas->join('town', 'town.town_id', '=', 'property.town_id')
                ->where('town.town_name', $request->location);


        }
        if ($request->towncity) {

            $datas = $datas
                ->join('town', 'town.town_id', '=', 'property.town_id')
                //                ->where('town.town_name',$request->location)
                ->where('town.town_name', $request->towncity);
        }
        if ($request->nobathrooms) {

            $datas = $datas->where('property.no_toilets', $request->nobathrooms);
        }


        if ($request->amenities_id) {
            //this part is not working

            $datas = $datas->join('property_amenities', 'property_amenities.property_id', '=', 'property.id')

                ->whereIn('property_amenities.amenities_id', [implode(',', $request->amenities_id)]);

        }

        if ($request->propertytype) {
            $datas = $datas->where('property_type_id', $request->propertytype);
        }

        if ($request->nobedrooms == 1) {
            $datas = $datas->where('no_bedrooms', 1);
        }
        if ($request->nobedrooms == 2) {
            $datas = $datas->where('no_bedrooms', 2);
        }
        if ($request->nobedrooms == 3) {
            $datas = $datas->where('no_bedrooms', 3);
        }
        if ($request->nobedrooms == 4) {
            $datas = $datas->where('no_bedrooms', 4);
        }
        if ($request->nobedrooms == 5) {
            $datas = $datas->where('no_bedrooms', 5);
        }
        if ($request->nobedrooms == 6) {
            $datas = $datas->where('no_bedrooms', '>', 6);
        }
        if ($request->singleprice) {
            if ($request->singleprice == 1) {
                $datas = $datas->whereBetween('price_asked', [0, 10000]);
            } elseif ($request->singleprice == 2) {
                $datas = $datas->whereBetween('price_asked', [10000, 15000]);
            } elseif ($request->singleprice == 3) {
                $datas = $datas->whereBetween('price_asked', [12000, 25000]);
            } elseif ($request->singleprice == 4) {
                $datas = $datas->whereBetween('price_asked', [30000, 35001]);
            } elseif ($request->singleprice == 5) {
                $datas = $datas->whereBetween('price_asked', [40000, 45001]);
            } elseif ($request->singleprice == 6) {
                $datas = $datas->whereBetween('price_asked', [50000, 55001]);
            } elseif ($request->singleprice == 7) {
                $datas = $datas->whereBetween('price_asked', [60000, 65001]);
            }


        }
        $datas = $datas->paginate(4);


        $town = Town::where('town_status', 'active')->get();
        $propertytypes = PropertyType::where('property_type_status', 'Active')->get();

        $html = '';

        if (count($datas) > 0) {
            $html = '    <div class="row justify-content-center">
               <div class="col-lg-12 col-md-12">
                  <div class="item-shorting-box">
                     <div class="item-shorting clearfix">
                        <div class="left-column pull-left"><h4 class="m-0" >Found <span id="">' . $request->page . ' - </span> ' . count($datas) . ' of ' . $datas->total() . ' Results</h4></div>
                     </div>

                  </div>
               </div>
            </div>';
            foreach ($datas as $property) {


                $html .= '               <div class="col-lg-12 col-md-12">
                  <div class="property-listing property-1">

                     <div class="listing-img-wrapper">
                        <a href="">
                           <img src="' . $path . $property->images_video . '" class="img-fluid mx-auto" alt="" />
                        </a>
                     </div>

                     <div class="listing-content">

                        <div class="listing-detail-wrapper-box">
                           <div class="listing-detail-wrapper">
                              <div class="listing-short-detail">
                                 <h4 class="listing-name"><a href="' . route('single-property', $property->slug) . ' " >' . $property->property_headline . '</a></h4>
                                 <div class="fr-can-rating">
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="reviews_text">(42 Reviews)</span>
                                 </div>
                                 <span class="prt-types sale">' . $property->product_category_name . '</span>
                                 <span class="">' . $property->phone_1 . '</span>
                              </div>
                              <div class="list-price">
                                 <h6 class="listing-card-info-price">$' . $property->price_asked . '</h6>
                              </div>
                           </div>
                        </div>

                        <div class="price-features-wrapper">
                           <div class="list-fx-features">
                              <div class="listing-card-info-icon">
                                 <div class="inc-fleat-icon"><img src="' . url('/assets/frontend/img/bed.svg') . '" width="13" alt="" /></div>' . $property->no_bedrooms . ' Beds
                              </div>
                              <div class="listing-card-info-icon">
                                 <div class="inc-fleat-icon"><img src="' . url('/assets/frontend/img/bathtub.svg') . '" width="13" alt="" /></div>' . $property->no_toilets . ' Bath
                              </div>
                              <div class="listing-card-info-icon">
                                 <div class="inc-fleat-icon"><img src="' . url('/assets/frontend/img/move.svg') . '" width="13" alt="" /></div>' . $property->land_area . ' sqft
                              </div>
                           </div>
                        </div>

                        <div class="listing-footer-wrapper">
                           <div class="listing-locate">
                           <span class="listing-location"><i class="ti-location-pin"></i>' . $property->street_name . '&nbsp &nbspAgent:- ' . $property->full_name . '</span>
                           </div>
                           <div class="listing-detail-btn">
                              <a href="' . route('single-property', $property->slug) . '" class="more-btn">View</a>
                           </div>
                        </div>

                     </div>

                  </div>
               </div>';

            }
            return response()->json(['datas' => $datas, 'html' => $html, 'pagination' => (string) $datas->links('components.custompagination')]);
        } else {
            $html .= '<h1 style="margin-top: 272px">No Data Found....</h1>';
        }
        return response()->json(['html' => $html]);

    }




    public function singleproperty($slug)
    {
        $agentimage = AgentImage();

        $property = Property::with('PropertyClass', 'ProductCategory', 'Province', 'PropertyImages', 'PropertyType', 'PropertyFloor', 'PropertyAgent')
            ->where('slug', $slug)->first();



        $property_images = PropertyImages::where('property_id', $property->id)->where('type', 'Image')->get();
        $property_video = PropertyImages::where('property_id', $property->id)->where('type', 'Video')->get();
        $phone = DB::table('user_details')->where('user_id', $property->agent_id)->first();
        $property_amenities = DB::table('property')
            ->join('property_amenities', 'property.id', '=', 'property_amenities.property_id')
            ->join('master_amenities', 'property_amenities.amenities_id', '=', 'master_amenities.id')
            ->where('master_amenities.status', 'Active')
            ->where('property_amenities.status', 'Active')
            ->where('property.id', $property->id)
            ->select('master_amenities.name')->get();
        $detailfeatures = DB::table('property')
            ->join('property_feature_mapping', 'property_feature_mapping.property_id', '=', 'property.id')
            ->join('features_master', 'features_master.feature_id', '=', 'property_feature_mapping.feature_id')
            ->where('property_feature_mapping.mapping_status', 'Active')
            ->where('features_master.feature_status', 'Active')
            ->where('property.id', $property->id)
            ->select('features_master.feature_name')
            ->get();


        $propertyfeatured = Property::with('PropertyClass', 'ProductCategory', 'Province', 'PropertyImages', 'PropertyType', 'PropertyFloor')->where('isFeatured', true)->get();

        return view('Frontend.singleproperty', compact('detailfeatures', 'agentimage', 'property', 'property_images', 'property_video', 'property_amenities', 'propertyfeatured', 'phone'));
    }












}