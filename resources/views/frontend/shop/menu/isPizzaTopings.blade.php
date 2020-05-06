<h5 style="text-transform: capitalize;">
    {{ $product['topings']['name'] }}
</h5>
<div class="form-group col-md-12 p0">
    <table style="width:100%;">
        <thead>
            <tr>
                <td style="width:61% !important;">&nbsp;</td>
                <td style="width:13% !important;text-align:center;font-size:10pt;"><strong>First Half</strong></td>
                <td style="width:13% !important;text-align:center;font-size:10pt;"><strong>Whole</strong></td>
                <td style="width:13% !important;text-align:center;font-size:10pt;"><strong>Second Half</strong></td>
            </tr>
        </thead>
        <tbody>
        @foreach($product['topings']['options'] as $topingKey=>$toping)
            @if($toping!=null)
            <tr>
                <td style="width:61%;">
                    <p id="category_{{$categoryKey}}_product_{{$productKey}}_pizzaShow_{!! $topingKey !!}">{{ $toping['name'] }}</p>
                </td>
                <td style="width:13%;text-align:center;">
                    <label class="pizzaRadioContainerFirstHalf">
                        <input type="radio"
                               name="category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               id="category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               class="mealNowTopping category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               value="{!! $topingKey !!}"
                               onclick="addTopingToCart({{$productKey}},'{{ $toping['name'] }}',1,{{$categoryKey}},{{$topingKey}})"/>
                        <span class="pizzaIconFirstHalf"></span>
                    </label>
                </td>
                <td style="width:13%;text-align:center;">
                    <label class="pizzaRadioContainerWhole">
                        <input type="radio"
                               name="category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               id="category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               class="mealNowTopping category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               value="{!! str_replace(' ','_',$toping['name']) !!}"
                               onclick="addTopingToCart({{$productKey}},'{{ $toping['name'] }}',3,{{$categoryKey}},{{$topingKey}})" />
                        <span class="pizzaIconWhole"></span>
                    </label>
                </td>
                <td style="width:13%;text-align:center;">
                    <label class="pizzaRadioContainerSecondHalf">
                        <input type="radio"
                               name="category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               id="category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               class="mealNowTopping category_{{$categoryKey}}_product_{{$productKey}}_toping_{!! $topingKey !!}"
                               value="{!! str_replace(' ','_',$toping['name']) !!}"
                               onclick="addTopingToCart({{$productKey}},'{{ $toping['name'] }}',2,{{$categoryKey}},{{$topingKey}})" />
                        <span class="pizzaIconSecondtHalf"></span>
                    </label>
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
