namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleCors
{
    public function handle(Request $request, Closure $next)
    {
        // Permet à n'importe quelle origine d'accéder à l'API
        $response = $next($request);

        // En-têtes CORS
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        
        // Si la méthode de la requête est OPTIONS, la réponse doit être envoyée sans exécution du reste du middleware
        if ($request->getMethod() == "OPTIONS") {
            return response('', 200, $response->headers->all());
        }

        return $response;
    }
}
