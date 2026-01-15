use App\Models\Menu;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function tambah(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$menu->id])) {
            $keranjang[$menu->id]['qty']++;
        } else {
            $keranjang[$menu->id] = [
                'nama' => $menu->name,
                'harga' => $menu->price,
                'qty' => 1
            ];
        }

        session()->put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang');
    }
}
