# Laravel Dynamic SEO Schema Builder

Laravel projelerinde arama motorları için dinamik Google Yapısal Veri (JSON-LD) şemaları üretmenizi sağlayan, hafif ve bağımlılıksız bir Trait sınıfı.

E-ticaret sistemleri, kurumsal web siteleri ve bloglar için tasarlanmış olup, manuel olarak JSON şeması oluşturma zahmetini tamamen ortadan kaldırır.

## Özellikler (Features)

Tek bir Trait ile aşağıdaki tüm Google yapısal veri formatlarını dinamik olarak modelleriniz üzerinden oluşturabilirsiniz:

- **Product Schema:** E-ticaret ürün detay sayfaları (stok, fiyat ve para birimi entegrasyonu).
- **Article/BlogPosting Schema:** SEO uyumlu blog yazıları, tarih ve yazar bilgisi.
- **BreadcrumbList Schema:** Google arama sonuçlarında düzgün hiyerarşi ve navigasyon gösterimi.
- **FAQPage Schema:** Sıkça sorulan sorular için Zengin Sonuçlar (Rich Snippets) entegrasyonu.
- **Organization Schema:** Kurumsal kimlik ve iletişim bilgilerinin arama motorlarına aktarımı.

## Canlı Kullanım Örneği (Use Case)

Bu eklentinin çekirdek mimarisi, promosyon ve matbaa sektöründe hizmet veren, binlerce ürüne sahip **[Bambaşkı Lazer Markalama ve Baskı Hizmetleri](https://bambaski.com.tr)** B2B e-ticaret altyapısında geliştirilmiş ve Google zengin sonuçlar görünürlüğünü otomatize etmek amacıyla canlı ortamda aktif olarak kullanılmaktadır.

## 🛠 Kurulum

1. Bu repodaki `HasSeoSchema.php` dosyasını kopyalayın ve Laravel projenizdeki `app/Traits` (veya belirlediğiniz uygun bir dizin) klasörüne yapıştırın.
2. Şema üretmek istediğiniz Model dosyanıza (örn: `Product.php` veya `Post.php`) Trait'i dahil edin:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSeoSchema;

class Product extends Model
{
    use HasSeoSchema;
    
    // Model içeriğiniz...
}


Kullanım Örnekleri
1. Ürün Sayfaları (Product Schema)
Blade sayfanızın (show.blade.php) <head> etiketleri arasına veya en altına ekleyin:

Blade
{!! $product->generateProductSchema() !!}
2. Blog Yazıları (Article Schema)
Blade
{!! $post->generateArticleSchema() !!}
3. Ekmek Kırıntısı (Breadcrumb Schema)
Controller veya View dosyanızda dinamik bir dizi oluşturarak gönderebilirsiniz:

Blade
{!! $model->generateBreadcrumbSchema([
    ['name' => 'Anasayfa', 'url' => url('/')],
    ['name' => 'Blog', 'url' => url('/blog')],
    ['name' => $post->title, 'url' => url()->current()]
]) !!}
4. Sıkça Sorulan Sorular (FAQ Schema)
Blade
{!! $model->generateFaqSchema([
    ['question' => 'Minimum sipariş adedi nedir?', 'answer' => 'Toptan alımlarda minimum sipariş adedimiz 50 adettir.'],
    ['question' => 'Hangi baskı teknolojilerini kullanıyorsunuz?', 'answer' => 'UV DTF, Lazer Markalama ve Süblimasyon baskı kullanmaktayız.']
]) !!}
5. Kurumsal Şema (Organization Schema)
Genellikle uygulamanızın ana şablonunda (app.blade.php veya footer.blade.php) kullanılır:

Blade
{!! $model->generateOrganizationSchema() !!}
Lisans
Bu proje açık kaynaklıdır ve MIT lisansı altında dağıtılmaktadır. Dilediğiniz gibi kullanabilir ve geliştirebilirsiniz.
